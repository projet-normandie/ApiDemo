<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetByIdsQuery;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;

/**
 * Class GetByIdsQueryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query
 *
 * @coversDefaultClass GetByIdsQuery
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetByIdsQueryTest extends TestCase
{
    /**
     * @var GetByIdsQuery
     */
    protected $query;

    /**
     * @var array
     */
    protected $entityIds;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->entityIds = ['id1', 'id2', 'id3'];
        $this->query = new GetByIdsQuery($this->entityIds);
    }

    /**
     * Tests the query interface.
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(QueryInterface::class, $this->query);
    }

    /**
     * Tests the getters.
     *
     * @covers AbstractGetByIdsQuery::getEntityIds
     */
    public function testGetters(): void
    {
        static::assertEquals($this->entityIds, $this->query->getEntityIds());
    }
}
