<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Workflow\Actor\Observer\ValueObject;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use DemoApiContext\Domain\Workflow\Actor\Handler\CreateManyWFHandler;
use DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject\WFGenerateVOCreateMany;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class WFGenerateVOCreateManyTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @coversDefaultClass WFGenerateVOCreateMany
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class WFGenerateVOCreateManyTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of CreateManyWFHandler.
     * @see CreateManyWFHandler
     */
    protected $wfHandler;

    /** @var WFGenerateVOCreateMany $wfGenerateVO */
    protected $wfGenerateVO;

    /** @var CreateManyCommand $createManyCommand */
    protected $createManyCommand;

    /**
     * Configures the test.
     */
    protected function setUp(): void
    {
        $this->createManyCommand = new CreateManyCommand(
            [
                new CreateOneCommand(
                    'lastName',
                    'firstName',
                    'M',
                    '1999-05-05',
                    'toto@free.fr',
                    '0144556676',
                    null,
                    1000.0,
                    'EUR'
                ),
                new CreateOneCommand(
                    'lastName',
                    'firstName',
                    'M',
                    '1999-05-05',
                    'toto@free.fr',
                    '0144556676',
                    null,
                    1000.0,
                    'EUR'
                )
            ]
        );
        $this->wfGenerateVO = new WFGenerateVOCreateMany();
    }

    /**
     * Tests Update for Creating many commands.
     *
     * @covers AbstractObserver::notify()
     */
    public function testUpdateForCreateManyCommand(): void
    {
        $this->wfHandler = Phake::mock(CreateManyWFHandler::class);
        $this->wfHandler->wfLastData = new stdClass();
        $this->wfHandler->wfLastData->createOneCommands = [$this->createManyCommand->getCreateOneCommands()];
        Phake::when($this->wfHandler)->getCommand()->thenReturn($this->createManyCommand);
        Phake::when($this->wfHandler)->getData()->thenReturn($this->wfHandler->wfLastData);
        $result = $this->wfGenerateVO->notify($this->wfHandler);
        static::assertInstanceOf(WFGenerateVOCreateMany::class, $result);
        static::assertCount(2, $this->createManyCommand);
    }
}
