<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject;

use DemoApiContext\Domain\ValueObject\ActorVO;
use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CreateOneCommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;

/**
 * Class WFGenerateVOCreateMany
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @license MIT
 */
class WFGenerateVOCreateMany extends AbstractWFGenerateVO
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
        return $this->setActorVO();
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
            [$this, 'buildActorVOFromCommand'],
            $this->wfLastData->createOneCommands
        );
        return $this;
    }

    /**
     * Builds an object ActorVO from the CreateOneCommand given.
     *
     * @param CreateOneCommandInterface $command
     * @return ActorVO
     * @throws Exception
     */
    private function buildActorVOFromCommand(CreateOneCommandInterface $command): ActorVO
    {
        return $this->buildActorVO(static::buildFromObject($command));
    }
}
