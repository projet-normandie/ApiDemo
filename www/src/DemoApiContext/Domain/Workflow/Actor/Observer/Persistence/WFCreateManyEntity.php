<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\Persistence;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\ValueObject\ActorVO;
use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;

/**
 * Class WFCreateManyEntity
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\Persistence
 *
 * @license MIT
 */
class WFCreateManyEntity extends WFSaveEntity
{
    use TraitStdClass;

    /**
     * Sends a persist action create to specific create manager for all entities.
     *
     * @uses WFCreateManyEntity::processToManager()
     * @return AbstractObserver
     */
    public function update(): AbstractObserver
    {
        $this->wfLastData->entity = \array_map(
            [$this, 'processToManager'],
            $this->wfLastData->actorVO
        );
        return $this;
    }

    /**
     * Checks that the value object linked to the entity is well defined and asks the manager to process if it is.
     *
     * @param ActorVO $actorVO Should be an instance of ActorVO, to avoid throwing an exception.
     * @used-by WFCreateManyEntity::update()
     * @return Actor
     * @throws Exception
     */
    private function processToManager(ActorVO $actorVO): Actor
    {
        $this->checkVO([$actorVO], DomainException::someValueObjectHaveNotBeenCreated());
        return $this->manager->process(static::buildFromArray(['actorVO' => $actorVO]));
    }
}
