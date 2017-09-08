<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Service\Actor\Processor;

use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Service\Actor\Processor\PostPersistProcess;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Generator\IdGenerator;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Logger\Generalisation\LoggerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Processor\ProcessInterface;

/**
 * Class PostPersistProcessTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Service\Actor\Processor
 *
 * @coversDefaultClass PostPersistProcess
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PostPersistProcessTest extends TestCase
{
    /**
     * @var Phake_IMock $logger Mock instance of LoggerInterface.
     * @see LoggerInterface
     */
    protected $logger;

    /** @var PostPersistProcess $postPersistProcess */
    protected $postPersistProcess;

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
        $this->postPersistProcess = new PostPersistProcess();
        $this->postPersistProcess->setLogger($this->logger);
        Phake::when($this->entity)->getId()->thenReturn(IdGenerator::generate());
    }

    /**
     * Tests Update method.
     *
     * @covers PostPersistProcess::update()
     */
    public function testUpdate(): void
    {
        static::assertInstanceOf(ProcessInterface::class, $this->postPersistProcess);
        $this->postPersistProcess->update($this->entity);
        Phake::verify($this->logger, Phake::times(1))->info(Phake::anyParameters());
    }
}
