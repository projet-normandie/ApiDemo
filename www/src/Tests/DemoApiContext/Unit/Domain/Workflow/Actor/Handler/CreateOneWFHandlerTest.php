<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Workflow\Actor\Handler;

use DemoApiContext\Domain\Workflow\Actor\Handler\CreateOneWFHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Generalisation\Observer\ObserverInterface;
use Tests\Generalisation\TraitPrivateProperty;

/**
 * Class CreateOneWFHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Workflow\Actor\Handler
 *
 * @coversDefaultClass CreateOneWFHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateOneWFHandlerTest extends TestCase
{
    use TraitPrivateProperty;

    /** @var string Fake kernel environment to use for observers. */
    public const KERNEL_ENV = 'TestEnv';

    /** @var CreateOneWFHandler $wfHandler */
    protected $wfHandler;

    /**
     * @var Phake_IMock Mock instance of CommandInterface.
     * @see CommandInterface
     */
    protected $command;

    /**
     * @var Phake_IMock Mock instance of ObserverInterface.
     * @see ObserverInterface
     */
    protected $observer1;

    /**
     * @var Phake_IMock Mock instance of ObserverInterface.
     * @see ObserverInterface
     */
    protected $observer2;

    /**
     * @var Phake_IMock Mock instance of ObserverInterface.
     * @see ObserverInterface
     */
    protected $observer3;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->command = Phake::mock(CommandInterface::class);
        $this->observer1 = Phake::mock(ObserverInterface::class);
        $this->observer2 = Phake::mock(ObserverInterface::class);
        $this->observer3 = Phake::mock(ObserverInterface::class);

        Phake::when($this->observer1)->notify(Phake::anyParameters())->thenReturn($this->observer1);
        Phake::when($this->observer2)->notify(Phake::anyParameters())->thenReturn($this->observer2);
        Phake::when($this->observer3)->notify(Phake::anyParameters())->thenReturn($this->observer3);

        $this->wfHandler = new CreateOneWFHandler(static::KERNEL_ENV);
        $this->wfHandler->addObserver($this->observer1)
            ->addObserver($this->observer2)
            ->addObserver($this->observer3);
    }

    /**
     * Tests Add Observer.
     *
     * @covers AbstractWFHandler::addObserver()
     */
    public function testAddObserver(): void
    {
        $observers = static::getPrivateProperty('observers', $this->wfHandler);
        static::assertCount(3, $observers);
        foreach ($observers as $observer) {
            static::assertInstanceOf(ObserverInterface::class, $observer);
        }
        $this->wfHandler->addObserver(Phake::mock(ObserverInterface::class));
        $observers = static::getPrivateProperty('observers', $this->wfHandler);
        static::assertCount(4, $observers);
        static::assertInstanceOf(ObserverInterface::class, \end($observers));
    }

    /**
     * Tests Add Observer.
     *
     * @covers AbstractWFHandler::addObserver()
     */
    public function testAddObserverWithGoodEnvironment(): void
    {
        $observers = static::getPrivateProperty('observers', $this->wfHandler);
        static::assertCount(3, $observers);
        foreach ($observers as $observer) {
            static::assertInstanceOf(ObserverInterface::class, $observer);
        }
        $this->wfHandler->addObserver(Phake::mock(ObserverInterface::class), [static::KERNEL_ENV]);
        $observers = static::getPrivateProperty('observers', $this->wfHandler);
        static::assertCount(4, $observers);
        static::assertInstanceOf(ObserverInterface::class, \end($observers));
    }

    /**
     * Tests Add Observer.
     *
     * @covers AbstractWFHandler::addObserver()
     */
    public function testAddObserverWithBadEnvironment(): void
    {
        $observers = static::getPrivateProperty('observers', $this->wfHandler);
        static::assertCount(3, $observers);
        foreach ($observers as $observer) {
            static::assertInstanceOf(ObserverInterface::class, $observer);
        }
        $this->wfHandler->addObserver(Phake::mock(ObserverInterface::class), ['_bad_env_']);
        $observers = static::getPrivateProperty('observers', $this->wfHandler);
        static::assertCount(3, $observers);
        static::assertInstanceOf(ObserverInterface::class, \end($observers));
    }

    /**
     * Tests getCommand method.
     *
     * @covers AbstractWFHandler::getCommand()
     */
    public function testGetCommand(): void
    {
        $this->wfHandler->process($this->command);
        $command = $this->wfHandler->getCommand();
        static::assertInstanceOf(CommandInterface::class, $command);
    }

    /**
     * Tests process method.
     *
     * @covers AbstractWFHandler::process()
     */
    public function testProcess(): void
    {
        $this->wfHandler->process($this->command);
        Phake::verify($this->observer1, Phake::times(1))->notify(Phake::anyParameters());
        Phake::verify($this->observer2, Phake::times(1))->notify(Phake::anyParameters());
        Phake::verify($this->observer3, Phake::times(1))->notify(Phake::anyParameters());
        static::assertSame($this->command, $this->wfHandler->getCommand());
    }
}
