<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject;

use DemoApiContext\Domain\Entity\Actor;
use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;

/**
 * Class WFGenerateVOPatchOne
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @license MIT
 */
class WFGenerateVOPatchOne extends AbstractWFGenerateVO
{
    use TraitStdClass;

    /**
     * Main observer method.
     * Prepares the last data in the workflow data so this method can call all VO setters to construct the required list
     * of VO in the workflow data the entity will be build with.
     *
     * @throws Exception
     * @return AbstractObserver
     */
    protected function update(): AbstractObserver
    {
        return $this->prepareData()->setActorVO();
    }

    /**
     * Prepares the wfLastData merging in a smart way the entity data and the command data.
     *
     * @return self
     */
    protected function prepareData(): self
    {
        /** @var Actor $actor */
        $actor = $this->wfLastData->entity;
        /** Recovered properties because it needs to be already built, thanks to WFLoadEntity observer. */
        $actorVO = $actor->getActor();

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

        // Use the values of the last workflow in an array.
        $rawLastData = (array)$this->wfLastData;

        // Intersect both previously defined arrays to only keep the patched values.
        $aPatchOneValue = \array_intersect_key(\array_filter($rawLastData), $rawEntity);

        // Apply the patched values to the last step (this step) to be ready to be used for the VO generation.
        $wfLastData = \array_merge($rawLastData, $rawEntity, $aPatchOneValue);
        $this->wfLastData = static::buildFromArray($wfLastData);

        return $this;
    }

    /**
     * Builds and sets the ActorVO in the workflow data.
     *
     * @return self
     * @throws Exception
     */
    protected function setActorVO(): self
    {
        $this->wfLastData->actorVO = $this->buildActorVO($this->wfLastData);
        return $this;
    }
}
