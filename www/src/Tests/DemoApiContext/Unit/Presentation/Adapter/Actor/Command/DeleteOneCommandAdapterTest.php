<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteOneCommand;
use DemoApiContext\Presentation\Adapter\Actor\Command\DeleteOneCommandAdapter;
use DemoApiContext\Presentation\Request\Actor\Command\DeleteOneRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class DeleteOneCommandAdapterTest
 * This class permits to test the DeleteOneCommandAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @coversDefaultClass DeleteOneCommandAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteOneCommandAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of DeleteOneRequest.
     * @see DeleteOneRequest
     */
    protected $request;

    /** @var DeleteOneCommandAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(DeleteOneRequest::class);
        Phake::when($this->request)->get('revision')->thenReturn('');

        Phake::when($this->request)->getRequestParameters()
            ->thenReturn(
                ['entityId' => 'good', 'revision' => '']
            );
        $this->adapter = new DeleteOneCommandAdapter();
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
        static::assertArrayHasKey('revision', $this->request->getRequestParameters());
        static::assertInstanceOf(CommandInterface::class, $command);
        static::assertInstanceOf(DeleteOneCommand::class, $command);
    }
}
