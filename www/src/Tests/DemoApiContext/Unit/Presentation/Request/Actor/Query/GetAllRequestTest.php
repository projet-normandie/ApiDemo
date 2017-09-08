<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Query;

use DemoApiContext\Presentation\Request\Actor\Query\GetAllRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class GetAllRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Query
 *
 * @coversDefaultClass GetAllRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetAllRequestTest extends TestCase
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
     * Tests GetAllRequest class methods.
     *
     * @covers GetAllRequest::__construct
     * @covers GetAllRequest::getRequestParameters
     */
    public function testRequest(): void
    {
        $limit = Phake::mock(Limit::class);
        Phake::when($this->request)->getContent()->thenReturn('{"limit":{"start":"100","count":"200"}}');
        Phake::when($this->resolver)->resolve(Phake::anyParameters())->thenReturn(['limit' => $limit]);
        $request = new GetAllRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls();
        $this->verifySetAllowedTypesCalls();

        static::assertEquals(true, \array_key_exists('limit', $params));
        static::assertEquals($limit, $params['limit']);
    }
}
