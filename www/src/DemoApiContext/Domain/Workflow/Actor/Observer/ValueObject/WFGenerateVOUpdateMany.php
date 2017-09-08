<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject;

use DemoApiContext\Domain\ValueObject\ActorVO;
use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\UpdateOneCommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Workflow\Generalisation\TraitEntityIdUpdateMany;

/**
 * Class WFGenerateVOUpdateMany
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @license MIT
 */
class WFGenerateVOUpdateMany extends AbstractWFGenerateVO
{
    use TraitStdClass;
    use TraitEntityIdUpdateMany;

    /**
     * Main observer method.
     * Calls all VO setters to construct the required list of VO in the workflow data all entities will be build with.
     *
     * @return AbstractObserver
     * @throws Exception
     */
    protected function update(): AbstractObserver
    {
        return $this->setEntityId()->setActorVO();
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
            $this->wfLastData->updateOneCommands
        );
        return $this;
    }

    /**
     * Builds an object ActorVO from the UpdateOneCommand given.
     *
     * @param UpdateOneCommandInterface $command
     * @return ActorVO
     * @throws Exception
     */
    private function buildActorVOFromCommand(UpdateOneCommandInterface $command): ActorVO
    {
        return $this->buildActorVO(static::buildFromObject($command));
    }
}
