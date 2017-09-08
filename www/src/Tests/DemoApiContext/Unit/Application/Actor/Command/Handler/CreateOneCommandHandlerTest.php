<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command\Handler;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\Handler\CreateOneCommandHandler;
use DemoApiContext\Domain\Entity\Actor;
use DemoApiContext\Domain\Workflow\Actor\Handler\CreateOneWFHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Workflow\Generalisation\TraitElementPointer;
use stdClass;

/**
 * Class CreateOneCommandHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command\Handler
 *
 * @coversDefaultClass CreateOneCommandHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateOneCommandHandlerTest extends TestCase
{
    use TraitElementPointer;

    /**
     * @var Phake_IMock $command Mock instance of CreateOneCommand.
     * @see CreateOneCommand
     */
    private $command;

    /**
     * @var Phake_IMock $entity Mock instance of Actor.
     * @see Actor
     */
    private $entity;

    /**
     * @var Phake_IMock $workflowHandler Mock instance of CreateOneWFHandler.
     * @see CreateOneWFHandler
     */
    private $workflowHandler;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->workflowHandler = Phake::mock(CreateOneWFHandler::class);
        $this->command = Phake::mock(CreateOneCommand::class);
        $this->entity = Phake::mock(Actor::class);
    }

    /**
     * Tests working workflow
     *
     * @covers AbstractSaveCommandHandler::process()
     */
    public function testCommandHandlerProcess(): void
    {
        $this->workflowHandler->process($this->command);
        $this->workflowHandler->data = new stdClass();
        $this->workflowHandler->data->entity = [];
        $this->workflowHandler->data->entity[] = $this->entity;
        Phake::when($this->workflowHandler)->getData()->thenReturn($this->workflowHandler->data);

        $result = static::getLastElement($this->workflowHandler->getData()->entity);
        static::assertSame($this->entity, $result);
        static::assertInstanceOf(Actor::class, $result);
        Phake::verify($this->workflowHandler, Phake::times(1))->process(Phake::anyParameters());
    }

    /**
     * Tests throwing the Exception.
     *
     * @covers AbstractSaveCommandHandler::process()
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\WorkflowException
     * @expectedExceptionMessage Entity has not been created
     */
    public function testCommandHandlerProcessException(): void
    {
        $this->workflowHandler->data = new stdClass();
        $this->workflowHandler->data->entity = [];
        Phake::when($this->workflowHandler)->getData()->thenReturn($this->workflowHandler->data);

        $createCommandHandlerProcess = new CreateOneCommandHandler($this->workflowHandler);
        $createCommandHandlerProcess->process($this->command);
        Phake::verify($this->workflowHandler, Phake::times(1))->process(Phake::anyParameters());
    }
}
