<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Query\Handler;

use DemoApiContext\Application\Cqrs\Actor\Query\GetByIdsQuery;
use DemoApiContext\Application\Cqrs\Actor\Query\Handler\GetByIdsQueryHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\Query\GetByIdsManager;

/**
 * Class GetByIdsQueryHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query\Handler
 *
 * @coversDefaultClass GetByIdsQueryHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetByIdsQueryHandlerTest extends TestCase
{
    /**
     * @var Phake_IMock $query Mock instance of GetByIdsQuery.
     * @see GetByIdsQuery
     */
    private $query;

    /**
     * @var Phake_IMock $manager Mock instance of GetByIdsManager.
     * @see GetByIdsManager
     */
    private $manager;

    /** @var GetByIdsQueryHandler $queryHandler */
    private $queryHandler;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->manager = Phake::mock(GetByIdsManager::class);
        Phake::when($this->manager)->process(Phake::anyParameters())->thenReturn([]);
        $this->query = Phake::mock(GetByIdsQuery::class);
        $this->queryHandler = new GetByIdsQueryHandler($this->manager);
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
