<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer;

use DemoApiContext\Domain\Entity\Actor;
use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Workflow\Generalisation\TraitManager;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Asserts\TraitAssertComparison;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\NotFoundException;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Generalisation\CouchDB\Query;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Workflow\Generalisation\TraitEntityIdPatchMany;

/**
 * Class WFLoadEntities
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer
 *
 * @license MIT
 */
class WFLoadEntities extends AbstractObserver
{
    use TraitStdClass;
    use TraitManager;
    use TraitEntityIdPatchMany;
    use TraitAssertComparison;

    /**
     * Main observer method.
     * Loads all Actors entities thanks to their identifier using the manager.
     * Entities are set in the workflow data.
     * @return AbstractObserver
     * @throws Exception
     */
    protected function update(): AbstractObserver
    {
        Query::setFetchingModeOnlyEntity();

        // Set all entities identifiers to the workflow data.
        $this->setEntityId();

        // Use them to load all entities.
        $this->wfLastData->entities = $this->manager->process(
            static::buildFromArray(['entityIds' => $this->wfLastData->entityId])
        );

        // Throw exception if the number of loaded entities is not the same as the number of entities to patch.
        static::assertStrictEquals(
            \count($this->wfLastData->entities),
            \count($this->wfLastData->entityId),
            NotFoundException::noResultForId(
                \array_diff(
                    $this->wfLastData->entityId,
                    \array_map(function (Actor $entity) {
                        return $entity->getId();
                    }, $this->wfLastData->entities)
                )
            )
        );

        return $this;
    }
}
