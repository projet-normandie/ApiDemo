<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\SearchByQuery;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Criteria;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\OrderBy;

/**
 * Class SearchByQueryTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Query
 *
 * @coversDefaultClass SearchByQuery
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class SearchByQueryTest extends TestCase
{
    /**
     * @var SearchByQuery
     */
    protected $query;

    /**
     * @var array
     */
    protected $criteria;

    /**
     * @var Limit
     */
    protected $limit;

    /**
     * @var null|OrderBy
     */
    protected $orderBy;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->criteria = \Phake::mock(Criteria::class);
        $this->limit = \Phake::mock(Limit::class);
        $this->orderBy = \Phake::mock(OrderBy::class);
        $this->query = new SearchByQuery($this->criteria, $this->limit, $this->orderBy);
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
     * @covers AbstractSearchByQuery::getCriteria()
     * @covers AbstractSearchByQuery::getLimit()
     * @covers AbstractSearchByQuery::getOrderBy()
     */
    public function testGetters(): void
    {
        static::assertEquals($this->criteria, $this->query->getCriteria());
        static::assertEquals($this->limit, $this->query->getLimit());
        static::assertEquals($this->orderBy, $this->query->getOrderBy());
    }

    /**
     * Tests the getters.
     *
     * @covers AbstractSearchByQuery::setCriteria
     * @covers AbstractSearchByQuery::setLimit
     * @covers AbstractSearchByQuery::setOrderBy
     */
    public function testSetters(): void
    {
        $criteria = \Phake::mock(Criteria::class);
        $limit = \Phake::mock(Limit::class);
        $orderBy = \Phake::mock(OrderBy::class);

        static::assertInstanceOf(SearchByQuery::class, $this->query->setCriteria($criteria));
        static::assertEquals($criteria, $this->query->getCriteria());

        static::assertInstanceOf(SearchByQuery::class, $this->query->setLimit($limit));
        static::assertEquals($limit, $this->query->getLimit());

        static::assertInstanceOf(SearchByQuery::class, $this->query->setOrderBy($orderBy));
        static::assertEquals($orderBy, $this->query->getOrderBy());

        static::assertInstanceOf(SearchByQuery::class, $this->query->setOrderBy(null));
        static::assertEquals(null, $this->query->getOrderBy());
    }
}
