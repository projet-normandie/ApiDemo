<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command\Handler;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\Handler\DeleteManyCommandHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Command\DeleteManyManager;

/**
 * Class DeleteManyCommandHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command\Handler
 *
 * @coversDefaultClass DeleteManyCommandHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteManyCommandHandlerTest extends TestCase
{
    /**
     * @var Phake_IMock $command Mock instance of DeleteManyCommand.
     * @see DeleteManyCommand
     */
    private $command;

    /**
     * @var Phake_IMock $manager Mock instance of DeleteManyManager.
     * @see DeleteManyManager
     */
    private $manager;

    /** @var DeleteManyCommandHandler */
    private $commandHandler;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->command = Phake::mock(DeleteManyCommand::class);
        $this->manager = Phake::mock(DeleteManyManager::class);

        $this->commandHandler = new DeleteManyCommandHandler($this->manager);
    }

    /**
     * Tests the working workflow.
     *
     * @covers AbstractDeleteManyCommandHandler::process()
     */
    public function testCommandHandlerProcess(): void
    {
        $this->commandHandler->process($this->command);
        Phake::verify($this->manager, Phake::times(1))->process(Phake::anyParameters());
        static::assertInternalType('array', $this->command->getDeleteOneCommands());
    }
}
