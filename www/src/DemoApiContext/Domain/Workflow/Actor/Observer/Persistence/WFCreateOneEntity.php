<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\Persistence;

use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;

/**
 * Class WFCreateOneEntity
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\Persistence
 *
 * @license MIT
 */
class WFCreateOneEntity extends WFSaveEntity
{
    use TraitStdClass;

    /**
     * Sends a persists action create to specific create manager.
     *
     * @return AbstractObserver
     * @throws Exception
     */
    public function update(): AbstractObserver
    {
        $this->wfLastData->entity = $this->manager->process(static::buildFromArray($this->checkEntityVO()));

        return $this;
    }
}
