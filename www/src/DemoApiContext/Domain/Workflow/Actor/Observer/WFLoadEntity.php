<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer;

use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Workflow\Generalisation\TraitManager;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Generalisation\CouchDB\Query;

/**
 * Class WFLoadEntity
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer
 *
 * @license MIT
 */
class WFLoadEntity extends AbstractObserver
{
    use TraitStdClass;
    use TraitManager;

    /**
     * Main observer method.
     * Loads the Actor entity thanks to its identifier using the manager.
     * The entity is set in the workflow data.
     *
     * @return AbstractObserver
     */
    protected function update(): AbstractObserver
    {
        //get actor by id
        Query::setFetchingModeOnlyEntity();
        $this->wfLastData->entity = $this->manager->process(
            static::buildFromArray(['entityId' => $this->wfLastData->entityId])
        );

        return $this;
    }
}
