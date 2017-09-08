<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Workflow\Actor\Observer;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Workflow\Actor\Handler\PatchOneWFHandler;
use DemoApiContext\Domain\Workflow\Actor\Observer\WFLoadEntity;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\ObservableInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\ManagerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetByIdsManager;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetOneManager;
use stdClass;

/**
 * Class WFLoadEntityTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Workflow\Actor\Observer
 *
 * @coversDefaultClass WFLoadEntity
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class WFLoadEntityTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of ObservableInterface.
     * @see ObservableInterface
     */
    protected $wfHandler;

    /** @var WFLoadEntity $wfLoadEntity */
    protected $wfLoadEntity;

    /**
     * @var Phake_IMock Mock instance of ManagerInterface.
     * @see ManagerInterface
     */
    protected $manager;

    /**
     * Configures the test.
     */
    protected function setUp(): void
    {
        $this->wfHandler = Phake::mock(PatchOneWFHandler::class);
        $this->wfHandler->data = $this->initData();

        $this->wfLoadEntity = new WFLoadEntity();
        $patchOneCommand = Phake::mock(PatchOneCommand::class);
        Phake::when($this->wfHandler)->getCommand()->thenReturn($patchOneCommand);
        Phake::when($this->wfHandler)->getData()->thenReturn($this->wfHandler->data);
    }

    /**
     * Tests loading entity with GetOneManager
     *
     * @covers AbstractObserver::notify()
     */
    public function testWithOneManager(): void
    {
        $entity = Phake::mock(Actor::class);
        $this->manager = Phake::mock(GetOneManager::class);
        Phake::when($this->manager)->find(Phake::anyParameters())->thenReturn($entity);

        $this->wfLoadEntity->setManager($this->manager);

        $result = $this->wfLoadEntity->notify($this->wfHandler);
        static::assertInstanceOf(WFLoadEntity::class, $result);
    }

    /**
     * Tests loading entity with GetByIdsManager
     *
     * @covers AbstractObserver::notify()
     */
    public function testWithGetByIdsManager(): void
    {
        $entity = Phake::mock(Actor::class);
        $this->manager = Phake::mock(GetByIdsManager::class);
        Phake::when($this->manager)->find(Phake::anyParameters())->thenReturn($entity);

        $this->wfLoadEntity->setManager($this->manager);

        $result = $this->wfLoadEntity->notify($this->wfHandler);
        static::assertInstanceOf(WFLoadEntity::class, $result);
    }

    /**
     * Initiates data.
     *
     * @return stdClass
     */
    public function initData(): stdClass
    {
        $data = new stdClass();
        $data->entityId = ['123456'];
        $data->birthday = ['12/12/2012'];
        return $data;
    }
}
