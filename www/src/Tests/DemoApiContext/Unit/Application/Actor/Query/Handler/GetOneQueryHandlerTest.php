<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Query\Handler;

use DemoApiContext\Application\Cqrs\Actor\Query\GetOneQuery;
use DemoApiContext\Application\Cqrs\Actor\Query\Handler\GetOneQueryHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetOneManager;

/**
 * Class GetOneQueryHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query\Handler
 *
 * @coversDefaultClass GetOneQueryHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetOneQueryHandlerTest extends TestCase
{
    /**
     * @var Phake_IMock $query Mock instance of GetOneQuery.
     * @see GetOneQuery
     */
    private $query;

    /**
     * @var Phake_IMock $manager Mock instance of GetOneManager.
     * @see GetOneManager
     */
    private $manager;

    /** @var GetOneQueryHandler $queryHandler */
    private $queryHandler;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->manager = Phake::mock(GetOneManager::class);
        Phake::when($this->manager)->process(Phake::anyParameters())->thenReturn([]);
        $this->query = Phake::mock(GetOneQuery::class);
        $this->queryHandler = new GetOneQueryHandler($this->manager);
    }

    /**
     * Tests GetOneQueryHandler process method.
     *
     * @covers AbstractQueryHandler::process()
     */
    public function testQueryHandlerProcess(): void
    {
        $returnQueryHandler = $this->queryHandler->process($this->query);
        Phake::verify($this->manager, Phake::times(1))->process(Phake::anyParameters());
        static::assertSame([], $returnQueryHandler);
    }
}
