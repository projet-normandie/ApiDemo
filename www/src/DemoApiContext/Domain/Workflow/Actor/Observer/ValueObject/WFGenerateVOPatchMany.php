<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;
use stdClass;

/**
 * Class WFGenerateVOPatchMany
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @license MIT
 */
class WFGenerateVOPatchMany extends AbstractWFGenerateVO
{
    use TraitStdClass;

    /**
     * Main observer method.
     * Calls all VO setters to construct the required list of VO in the workflow data all entities will be build with.
     *
     * @return AbstractObserver
     * @throws Exception
     */
    protected function update(): AbstractObserver
    {
        return $this->prepareData()->setActorVO();
    }

    /**
     * Prepares the wfLastData merging in a smart way the entity data and the command data for all commands.
     *
     * @return self
     */
    protected function prepareData(): self
    {
        $this->wfLastData->patchManyData = \array_map(
            [$this, 'prepareOneData'],
            $this->wfLastData->entities,
            $this->wfLastData->patchOneCommands
        );

        return $this;
    }

    /**
     * Prepares the wfLastData merging in a smart way the entity data and the command data for a single command.
     *
     * @param Actor $entity
     * @param PatchOneCommand $command
     * @return stdClass
     */
    protected function prepareOneData(Actor $entity, PatchOneCommand $command): stdClass
    {
        /** Recovered properties because it needs to be already built, thanks to WFLoadEntities observer. */
        $actorVO = $entity->getActor();

        // List the leaf level properties of all value objects that compose the entity.
        $rawEntity = [
            'lastName' => $actorVO->getProfile()->getLastName(),
            'firstName' => $actorVO->getProfile()->getFirstName(),
            'sex' => $actorVO->getSituation()->getSex(),
            'birthday' => $actorVO->getSituation()->getBirthday()->format('Y-m-d'),
            'email' => $actorVO->getContact()->getEmail(),
            'phoneNumber1' => $actorVO->getContact()->getPhoneNumber1(),
            'phoneNumber2' => $actorVO->getContact()->getPhoneNumber2(),
            'salary' => $actorVO->getSalary()->getValue(),
            'salaryCurrency' => $actorVO->getSalary()->getCurrency(),
        ];

        // Use the values of the command in an array.
        $rawLastData = $command->toArray();

        // Intersect both previously defined arrays to only keep the patched values.
        $aPatchOneValue = \array_intersect_key(\array_filter($rawLastData), $rawEntity);

        // Apply the patched values to the last step (this step) to be ready to be used for the VO generation.
        return static::buildFromArray(\array_merge($rawLastData, $rawEntity, $aPatchOneValue));
    }

    /**
     * Builds and sets the ActorVO in the workflow data for each commands.
     *
     * @return self
     * @throws Exception
     */
    protected function setActorVO(): self
    {
        $this->wfLastData->actorVO = \array_map(
            [$this, 'buildActorVOFromData'],
            $this->wfLastData->patchManyData
        );
        return $this;
    }

    /**
     * Builds an object ActorVO from the data given.
     *
     * @param stdClass $data
     * @return ActorVO
     * @throws Exception
     */
    private function buildActorVOFromData(stdClass $data): ActorVO
    {
        return $this->buildActorVO(static::buildFromObject($data));
    }
}
