<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetOneQuery;
use DemoApiContext\Presentation\Adapter\Actor\Query\GetOneQueryAdapter;
use DemoApiContext\Presentation\Request\Actor\Query\GetOneRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryInterface;

/**
 * Class GetOneQueryAdapterTest
 * This class permits to test the GetOneQueryAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @coversDefaultClass GetOneQueryAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetOneQueryAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of GetOneRequest.
     * @see GetOneRequest
     */
    protected $request;

    /** @var GetOneQueryAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(GetOneRequest::class);
        Phake::when($this->request)->getRequestParameters()->thenReturn(
            ['entityId' => 'good']
        );
        $this->adapter = new GetOneQueryAdapter();
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
        static::assertInstanceOf(GetOneQuery::class, $query);
    }
}
