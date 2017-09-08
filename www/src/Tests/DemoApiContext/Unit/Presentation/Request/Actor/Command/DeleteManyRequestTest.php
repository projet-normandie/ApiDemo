<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Command;

use DemoApiContext\Presentation\Request\Actor\Command\DeleteManyRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class DeleteManyRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @coversDefaultClass DeleteManyRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteManyRequestTest extends TestCase
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
        Phake::when($this->request)->getContent()->thenReturn('[{"entityId":"good"}, {"entityId":"johnny"}]');
        Phake::when($this->resolver)->resolve(Phake::anyParameters())
            ->thenReturn(['entityId' => 'good'])
            ->thenReturn(['entityId' => 'johnny']);
        $request = new DeleteManyRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls(2);
        $this->verifySetAllowedTypesCalls(2);

        static::assertEquals([['entityId' => 'good'], ['entityId' => 'johnny']], $params);
    }

    /**
     * Tests firing the exception.
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\PresentationException
     */
    public function testExceptionBecauseInvalidJson(): void
    {
        Phake::when($this->request)->getContent()->thenReturn('{"an":"invalid","json}');
        Phake::when($this->resolver)->resolve(Phake::anyParameters())->thenReturn(['entityIds' => ['good', 'johnny']]);
        new DeleteManyRequest($this->request, $this->resolver);
    }
}
