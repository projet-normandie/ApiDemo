<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Query;

use DemoApiContext\Presentation\Request\Actor\Query\SearchByRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Criteria;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\OrderBy;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class SearchByRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Query
 *
 * @coversDefaultClass SearchByRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class SearchByRequestTest extends TestCase
{
    use TraitVerifyResolver;

    /**
     * @var Phake_IMock $request Mock instance of RequestInterface.
     * @see RequestInterface
     */
    protected $request;

    /**
     * @var Phake_IMock $resolver Mock instance of ResolverInterface.
     * @see ResolverInterface
     */
    protected $resolver;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(RequestInterface::class);
        $this->resolver = Phake::mock(ResolverInterface::class);
    }

    /**
     * Tests SearchByRequest class methods.
     *
     * @covers SearchByRequest::__construct
     * @covers SearchByRequest::getRequestParameters
     */
    public function testRequest(): void
    {
        $criteria = Phake::mock(Criteria::class);
        $limit = Phake::mock(Limit::class);
        $orderBy = Phake::mock(OrderBy::class);
        Phake::when($this->request)->getContent()->thenReturn(
            '{
                "criteria":[],
                "limit":{"start":100,"count":200},
                "orderBy":[{"field":"test","asc":true}]
            }'
        );
        Phake::when($this->resolver)->resolve(Phake::anyParameters())->thenReturn([
            'criteria' => $criteria,
            'limit' => $limit,
            'orderBy' => $orderBy
        ]);
        $request = new SearchByRequest($this->request, $this->resolver, $criteria);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls();
        $this->verifySetAllowedTypesCalls(3);

        static::assertTrue(\array_key_exists('criteria', $params));
        static::assertTrue(\array_key_exists('limit', $params));
        static::assertTrue(\array_key_exists('orderBy', $params));
        static::assertEquals($criteria, $params['criteria']);
        static::assertEquals($limit, $params['limit']);
        static::assertEquals($orderBy, $params['orderBy']);
    }
}
