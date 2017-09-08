<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command\Handler;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteOneCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\Handler\DeleteOneCommandHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Command\DeleteOneManager;

/**
 * Class DeleteOneCommandHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command\Handler
 *
 * @coversDefaultClass DeleteOneCommandHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteOneCommandHandlerTest extends TestCase
{
    /**
     * @var Phake_IMock $command Mock instance of DeleteOneCommand.
     * @see DeleteOneCommand
     */
    private $command;

    /**
     * @var Phake_IMock $manager Mock instance of DeleteOneManager.
     * @see DeleteOneManager
     */
    private $manager;

    /** @var DeleteOneCommandHandler */
    private $commandHandler;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->command = Phake::mock(DeleteOneCommand::class);
        $this->manager = Phake::mock(DeleteOneManager::class);

        $this->commandHandler = new DeleteOneCommandHandler($this->manager);
    }

    /**
     * Tests a working workflow.
     *
     * @covers AbstractDeleteOneCommandHandler::process()
     */
    public function testCommandHandlerProcess(): void
    {
        $deleteOneReturn = 1;
        Phake::when($this->manager)->process(Phake::anyParameters())->thenReturn($deleteOneReturn);
        static::assertSame($deleteOneReturn, $this->commandHandler->process($this->command));
        Phake::verify($this->manager, Phake::times(1))->process(Phake::anyParameters());
    }
}
