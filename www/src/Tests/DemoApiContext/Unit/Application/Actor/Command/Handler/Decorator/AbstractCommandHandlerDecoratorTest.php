<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command\Handler\Decorator;

use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\Handler\Decorator\AbstractCommandHandlerDecorator;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandHandlerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandValidationHandlerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Validation\SpecHandler\SpecificationHandlerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Entity\EntityInterface;

/**
 * Class AbstractCommandHandlerDecoratorTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command\Handler\Decorator
 *
 * @coversDefaultClass AbstractCommandHandlerDecorator
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
abstract class AbstractCommandHandlerDecoratorTest extends TestCase
{
    /** @var AbstractCommandHandlerDecorator $decorator */
    protected $decorator;

    /**
     * @var Phake_IMock $commandHandler Mock instance of CommandHandlerInterface.
     * @see CommandHandlerInterface
     */
    protected $commandHandler;

    /**
     * @var Phake_IMock $validationHandler Mock instance of CommandValidationHandlerInterface.
     * @see CommandValidationHandlerInterface
     */
    protected $validationHandler;

    /**
     * @var Phake_IMock $specHandler Mock instance of SpecificationHandlerInterface.
     * @see SpecificationHandlerInterface
     */
    protected $specHandler;

    /**
     * @var Phake_IMock $command Mock instance of CommandInterface.
     * @see CommandInterface
     */
    protected $command;

    /**
     * @var Phake_IMock $entity Mock instance of EntityInterface.
     * @see EntityInterface
     */
    protected $entity;

    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        $this->commandHandler = Phake::mock(CommandHandlerInterface::class);
        $this->entity = Phake::mock(EntityInterface::class);
        Phake::when($this->commandHandler)->process(Phake::anyParameters())->thenReturn($this->entity);

        $this->validationHandler = Phake::mock(CommandValidationHandlerInterface::class);
        $this->specHandler = Phake::mock(SpecificationHandlerInterface::class);

        $this->command = Phake::mock(CommandInterface::class);
    }

    /**
     * Tests the process method.
     *
     * @covers AbstractCommandHandlerDecorator::process()
     */
    public function testProcess(): void
    {
        $decoratorProcessReturn = $this->decorator->process($this->command);
        static::assertSame($this->entity, $decoratorProcessReturn);

        Phake::verify($this->commandHandler, Phake::times(1))->process(Phake::anyParameters());
        Phake::verify($this->validationHandler, Phake::times(1))->process(Phake::anyParameters());
        Phake::verify($this->specHandler, Phake::times(1))->process(Phake::anyParameters());
    }
}
