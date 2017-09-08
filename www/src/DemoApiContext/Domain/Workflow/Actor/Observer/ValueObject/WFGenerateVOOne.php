<?php
declare(strict_types = 1);

namespace DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject;

use Exception;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\AbstractObserver;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Manipulation\TypeHinting\TraitStdClass;

/**
 * Class WFGenerateVOOne
 *
 * @category DemoApiContext
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @license MIT
 */
class WFGenerateVOOne extends AbstractWFGenerateVO
{
    use TraitStdClass;

    /**
     * Main observer method.
     * Calls all VO setters to construct the required list of VO in the workflow data the entity will be build with.
     *
     * @throws Exception
     * @return AbstractObserver
     */
    protected function update(): AbstractObserver
    {
        return $this->setActorVO();
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
