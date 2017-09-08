<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use DemoApiContext\Presentation\Adapter\Actor\Command\PatchOneCommandAdapter;
use DemoApiContext\Presentation\Request\Actor\Command\PatchOneRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class PatchOneCommandAdapterTest
 * This class permits to test the PatchOneCommandAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @coversDefaultClass PatchOneCommandAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PatchOneCommandAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of PatchOneRequest.
     * @see PatchOneRequest
     */
    protected $request;

    /** @var PatchOneCommandAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(PatchOneRequest::class);
        Phake::when($this->request)->getRequestParameters()
            ->thenReturn(
                [
                    'entityId' => 'good',
                    'lastName' => null,
                    'firstName' => null,
                    'sex' => 'F',
                    'birthday' => null,
                    'email' => null,
                    'phoneNumber1' => null,
                    'phoneNumber2' => null,
                    'salary' => null,
                    'salaryCurrency' => null
                ]
            );
        $this->adapter = new PatchOneCommandAdapter();
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
        static::assertArrayHasKey('entityId', $this->request->getRequestParameters());
        static::assertInstanceOf(CommandInterface::class, $command);
        static::assertInstanceOf(PatchOneCommand::class, $command);
    }
}
