<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteManyCommand;
use DemoApiContext\Presentation\Adapter\Actor\Command\DeleteManyCommandAdapter;
use DemoApiContext\Presentation\Request\Actor\Command\DeleteManyRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class DeleteManyCommandAdapterTest
 * This class permits to test the DeleteManyCommandAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @coversDefaultClass DeleteManyCommandAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteManyCommandAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of DeleteManyRequest.
     * @see DeleteManyRequest
     */
    protected $request;

    /** @var DeleteManyCommandAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(DeleteManyRequest::class);
        Phake::when($this->request)->getRequestParameters()
            ->thenReturn(
                [['entityId' => 'good', 'revision' => null], ['entityId' => 'johnny', 'revision' => null]]
            );
        $this->adapter = new DeleteManyCommandAdapter();
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
        static::assertInstanceOf(DeleteManyCommand::class, $command);
    }
}
