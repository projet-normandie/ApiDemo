<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetAllQuery;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;

/**
 * Class GetAllQueryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query
 *
 * @coversDefaultClass GetAllQuery
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetAllQueryTest extends TestCase
{
    /**
     * @var GetAllQuery
     */
    protected $query;

    /**
     * @var Limit
     */
    protected $limit;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->limit = \Phake::mock(Limit::class);
        $this->query = new GetAllQuery($this->limit);
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
     * @covers AbstractGetAllQuery::getLimit
     */
    public function testGetters(): void
    {
        static::assertEquals($this->limit, $this->query->getLimit());
    }

    /**
     * Tests the setters.
     *
     * @covers AbstractGetAllQuery::setLimit
     */
    public function testSetters(): void
    {
        $limit = \Phake::mock(Limit::class);
        static::assertInstanceOf(GetAllQuery::class, $this->query->setLimit($limit));
        static::assertEquals($limit, $this->query->getLimit());
    }
}
