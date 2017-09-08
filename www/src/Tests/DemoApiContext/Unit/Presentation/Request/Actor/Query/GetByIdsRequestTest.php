<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Query;

use DemoApiContext\Presentation\Request\Actor\Query\GetByIdsRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class GetByIdsRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Query
 *
 * @coversDefaultClass GetByIdsRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetByIdsRequestTest extends TestCase
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
     * Tests GetByIdsRequest class methods.
     *
     * @covers GetByIdsRequest::__construct
     * @covers GetByIdsRequest::getRequestParameters
     */
    public function testRequest(): void
    {
        Phake::when($this->request)->get('entityIds')->thenReturn(['good', 'johnny']);
        Phake::when($this->resolver)->resolve(Phake::anyParameters())->thenReturn(
            ['entityIds' => ['good', 'johnny']]
        );
        $request = new GetByIdsRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls();
        $this->verifySetAllowedTypesCalls();

        static::assertEquals(['good', 'johnny'], $params['entityIds']);
    }
}
