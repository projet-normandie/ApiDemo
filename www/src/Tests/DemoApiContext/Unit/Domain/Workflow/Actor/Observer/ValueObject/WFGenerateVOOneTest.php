<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Domain\Workflow\Actor\Observer\ValueObject;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\UpdateOneCommand;
use DemoApiContext\Domain\Workflow\Actor\Observer\ValueObject\WFGenerateVOOne;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Workflow\Generalisation\AbstractWFHandler;
use stdClass;

/**
 * Class WFGenerateVOOneTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Domain
 * @subpackage Workflow\Actor\Observer\ValueObject
 *
 * @coversDefaultClass WFGenerateVOOne
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class WFGenerateVOOneTest extends TestCase
{
    /**
     * @var Phake_IMock Mock instance of ObservableInterface.
     * @see ObservableInterface
     */
    protected $wfHandler;

    /** @var WFGenerateVOOne */
    protected $wfGenerateVoOne;

    /**
     * Configures the test.
     */
    protected function setUp(): void
    {
        $this->wfHandler = Phake::mock(AbstractWFHandler::class);
        $this->wfHandler->data = $this->initData();
        Phake::when($this->wfHandler)->getData()->thenReturn($this->wfHandler->data);
        $this->wfGenerateVoOne = new WFGenerateVOOne();
    }

    /**
     * Tests with CreateCommand.
     *
     * @covers AbstractObserver::notify()
     */
    public function testWithCreateCommand(): void
    {
        $createOneCommand = Phake::mock(CreateOneCommand::class);
        Phake::when($this->wfHandler)->getCommand()->thenReturn($createOneCommand);
        $result = $this->wfGenerateVoOne->notify($this->wfHandler);
        static::assertInstanceOf(WFGenerateVOOne::class, $result);
    }

    /**
     * Tests with UpdateCommand.
     *
     * @covers AbstractObserver::notify()
     */
    public function testWithUpdateCommand(): void
    {
        $updateCommand = Phake::mock(UpdateOneCommand::class);
        Phake::when($this->wfHandler)->getCommand()->thenReturn($updateCommand);
        $result = $this->wfGenerateVoOne->notify($this->wfHandler);
        static::assertInstanceOf(WFGenerateVOOne::class, $result);
    }

    /**
     * Initiates data.
     *
     * @return stdClass
     */
    public function initData(): stdClass
    {
        $data = new stdClass();
        $data->sex = ['M'];
        $data->birthday = ['12/12/2012'];
        $data->salary = ['5000'];
        $data->salaryCurrency = ['£'];
        return $data;
    }
}
