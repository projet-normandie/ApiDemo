<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use DemoApiContext\Presentation\Adapter\Actor\Command\CreateOneCommandAdapter;
use DemoApiContext\Presentation\Request\Actor\Command\CreateOneRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class CreateOneCommandAdapterTest
 * This class permits to test the CreateOneCommandAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @coversDefaultClass CreateOneCommandAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateOneCommandAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of CreateOneRequest.
     * @see CreateOneRequest
     */
    protected $request;

    /** @var CreateOneCommandAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(CreateOneRequest::class);
        Phake::when($this->request)->getRequestParameters()
            ->thenReturn(
                [
                    'lastName' => 'de nil',
                    'firstName' => 'laurent',
                    'sex' => 'F',
                    'birthday' => '2015-01-01',
                    'email' => 'johnny@good.com',
                    'phoneNumber1' => '0134342233',
                    'phoneNumber2' => '0612131415',
                    'salary' => 100000.0,
                    'salaryCurrency' => 'EUR'
                ]
            );
        $this->adapter = new CreateOneCommandAdapter();
    }

    /**
     * Tests buildCommandFromRequest method.
     *
     * @covers ::buildCommandFromRequest()
     */
    public function testNominal(): void
    {
        $command = $this->adapter->buildCommandFromRequest($this->request);
        Phake::verify($this->request, Phake::times(1))->getRequestParameters(Phake::anyParameters());
        static::assertInstanceOf(CommandInterface::class, $command);
        static::assertInstanceOf(CreateOneCommand::class, $command);
    }
}
