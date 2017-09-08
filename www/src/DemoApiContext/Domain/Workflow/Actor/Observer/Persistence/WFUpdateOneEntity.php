<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\Persistence;

use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;

/**
 * Class WFUpdateOneEntity
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\Persistence
 *
 * @license MIT
 */
class WFUpdateOneEntity extends WFSaveEntity
{
    use TraitStdClass;

    /**
     * Sends a persists action update to specific update manager.
     *
     * @return AbstractObserver
     * @throws Exception
     */
    public function update(): AbstractObserver
    {
        $aData = \array_merge(['entityId' => $this->wfLastData->entityId], $this->checkEntityVO());
        $this->wfLastData->entity = $this->manager->process(static::buildFromArray($aData));

        return $this;
    }
}
