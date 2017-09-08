<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\SearchByQuery;
use DemoApiContext\Presentation\Adapter\Actor\Query\SearchByQueryAdapter;
use DemoApiContext\Presentation\Request\Actor\Query\SearchByRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Criteria;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\OrderBy;

/**
 * Class SearchByQueryAdapterTest
 * This class permits to test the SearchByQueryAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @coversDefaultClass SearchByQueryAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class SearchByQueryAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of SearchByRequest.
     * @see SearchByRequest
     */
    protected $request;

    /** @var SearchByQueryAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(SearchByRequest::class);
        Phake::when($this->request)->getRequestParameters()->thenReturn(
            [
                'criteria' => Phake::mock(Criteria::class),
                'orderBy' => Phake::mock(OrderBy::class),
                'limit' => Phake::mock(Limit::class)
            ]
        );
        $this->adapter = new SearchByQueryAdapter();
    }

    /**
     * Tests buildQueryFromRequest method.
     *
     * @covers ::buildQueryFromRequest()
     */
    public function testNominal(): void
    {
        $query = $this->adapter->buildQueryFromRequest($this->request);
        Phake::verify($this->request, Phake::times(1))->getRequestParameters(Phake::anyParameters());
        static::assertInstanceOf(QueryInterface::class, $query);
        static::assertInstanceOf(SearchByQuery::class, $query);
    }
}
