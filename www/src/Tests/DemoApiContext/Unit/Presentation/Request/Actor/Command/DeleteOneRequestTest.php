<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Command;

use DemoApiContext\Presentation\Request\Actor\Command\DeleteOneRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class DeleteRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @coversDefaultClass DeleteOneRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteOneRequestTest extends TestCase
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
     * Tests the request.
     *
     * @covers AbstractCreateManyRequest::process()
     */
    public function testRequest(): void
    {
        Phake::when($this->request)->getContent()->thenReturn('{"entityId":"good"}');
        Phake::when($this->resolver)->resolve(Phake::anyParameters())->thenReturn(['entityId' => 'good']);
        $request = new DeleteOneRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls();
        $this->verifySetAllowedTypesCalls(2);

        static::assertEquals('good', $params['entityId']);
    }
}
