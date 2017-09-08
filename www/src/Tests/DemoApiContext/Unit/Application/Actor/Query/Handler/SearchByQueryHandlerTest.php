<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Actor\Query\Handler;

use DemoApiContext\Application\Cqrs\Actor\Query\Handler\SearchByQueryHandler;
use DemoApiContext\Application\Cqrs\Actor\Query\SearchByQuery;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\SearchByManager;

/**
 * Class SearchByQueryHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query\Handler
 *
 * @coversDefaultClass SearchByQueryHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class SearchByQueryHandlerTest extends TestCase
{
    /**
     * @var Phake_IMock $query Mock instance of SearchByQuery.
     * @see SearchByQuery
     */
    private $query;

    /**
     * @var Phake_IMock $manager Mock instance of SearchByManager.
     * @see SearchByManager
     */
    private $manager;

    /** @var SearchByQueryHandler $queryHandler */
    private $queryHandler;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->manager = Phake::mock(SearchByManager::class);
        Phake::when($this->manager)->process(Phake::anyParameters())->thenReturn([]);
        $this->query = Phake::mock(SearchByQuery::class);
        $this->queryHandler = new SearchByQueryHandler($this->manager);
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
