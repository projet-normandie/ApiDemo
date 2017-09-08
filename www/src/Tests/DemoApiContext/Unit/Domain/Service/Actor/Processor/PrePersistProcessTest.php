<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Processor;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Service\Actor\Processor\PrePersistProcess;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Generator\IdGenerator;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Processor\ProcessInterface;

/**
 * Class PrePersistProcessTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Processor
 *
 * @coversDefaultClass PrePersistProcess
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PrePersistProcessTest extends TestCase
{
    /**
     * @var Phake_IMock $logger Mock instance of LoggerInterface.
     * @see LoggerInterface
     */
    protected $logger;

    /** @var PrePersistProcess $prePersistProcess */
    protected $prePersistProcess;

    /**
     * @var Phake_IMock $entity Mock instance of Actor.
     * @see Actor
     */
    protected $entity;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->entity = Phake::mock(Actor::class);
        $this->logger = Phake::mock(LoggerInterface::class);
        $this->prePersistProcess = new PrePersistProcess();
        $this->prePersistProcess->setLogger($this->logger);
        Phake::when($this->entity)->getId()->thenReturn(IdGenerator::generate());
    }

    /**
     * Tests Update method.
     *
     * @covers PrePersistProcess::update()
     */
    public function testUpdate(): void
    {
        static::assertInstanceOf(ProcessInterface::class, $this->prePersistProcess);
        $this->prePersistProcess->update($this->entity);
        Phake::verify($this->logger, Phake::times(1))->info(Phake::anyParameters());
    }
}
