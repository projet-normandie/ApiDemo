<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\Persistence;

use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Workflow\Generalisation\{TraitManager, TraitVOChecker};
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\DomainException;

/**
 * Class WFSaveEntity
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\Persistence
 *
 * @license MIT
 */
abstract class WFSaveEntity extends AbstractObserver
{
    use TraitVOChecker;
    use TraitManager;

    /**
     * Verifies that the ActorVO given in the workflow data is valid.
     *
     * @return array Array of ValueObject validated.
     * @throws Exception
     */
    protected function checkEntityVO(): array
    {
        $aVO = ['actorVO' => $this->wfLastData->actorVO];
        $this->checkVO($aVO, DomainException::someValueObjectHaveNotBeenCreated());
        return $aVO;
    }
}
