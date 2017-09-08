<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetByIdsQuery;
use DemoApiContext\Presentation\Adapter\Actor\Query\GetByIdsQueryAdapter;
use DemoApiContext\Presentation\Request\Actor\Query\GetByIdsRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;

/**
 * Class GetByIdsQueryAdapterTest
 * This class permits to test the GetByIdsQueryAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @coversDefaultClass GetByIdsQueryAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetByIdsQueryAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of GetByIdsRequest.
     * @see GetByIdsRequest
     */
    protected $request;

    /** @var GetByIdsQueryAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(GetByIdsRequest::class);
        Phake::when($this->request)->getRequestParameters()->thenReturn(
            ['entityIds' => 'good, johnny']
        );
        $this->adapter = new GetByIdsQueryAdapter();
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
        static::assertInstanceOf(GetByIdsQuery::class, $query);
    }
}
