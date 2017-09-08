<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetAllQuery;
use DemoApiContext\Presentation\Adapter\Actor\Query\GetAllQueryAdapter;
use DemoApiContext\Presentation\Request\Actor\Query\GetAllRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;

/**
 * Class GetAllQueryAdapterTest
 * This class permits to test the GetAllQueryAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @coversDefaultClass GetAllQueryAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetAllQueryAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of GetAllRequest.
     * @see GetAllRequest
     */
    protected $request;

    /** @var GetAllQueryAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(GetAllRequest::class);
        Phake::when($this->request)->getRequestParameters()->thenReturn(
            ['limit' => Phake::mock(Limit::class)]
        );
        $this->adapter = new GetAllQueryAdapter();
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
        static::assertInstanceOf(GetAllQuery::class, $query);
    }
}
