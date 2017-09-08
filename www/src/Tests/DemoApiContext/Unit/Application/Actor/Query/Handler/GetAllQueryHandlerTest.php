<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Query\Handler;

use DemoApiContext\Application\Cqrs\Actor\Query\GetAllQuery;
use DemoApiContext\Application\Cqrs\Actor\Query\Handler\GetAllQueryHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetAllManager;

/**
 * Class GetAllQueryHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query\Handler
 *
 * @coversDefaultClass GetAllQueryHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetAllQueryHandlerTest extends TestCase
{
    /**
     * @var Phake_IMock $query Mock instance of GetAllQuery.
     * @see GetAllQuery
     */
    private $query;

    /**
     * @var Phake_IMock $manager Mock instance of GetAllManager.
     * @see GetAllManager
     */
    private $manager;

    /** @var GetAllQueryHandler $queryHandler */
    private $queryHandler;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->manager = Phake::mock(GetAllManager::class);
        Phake::when($this->manager)->process(Phake::anyParameters())->thenReturn([]);
        $this->query = Phake::mock(GetAllQuery::class);
        Phake::when($this->query)->getStart(Phake::anyParameters())->thenReturn(0);
        Phake::when($this->query)->getCount(Phake::anyParameters())->thenReturn(100);
        $this->queryHandler = new GetAllQueryHandler($this->manager);
    }

    /**
     * Tests GetAllQueryHandler process method.
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
