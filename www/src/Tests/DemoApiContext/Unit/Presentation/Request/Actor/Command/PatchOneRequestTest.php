<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Command;

use DemoApiContext\Presentation\Request\Actor\Command\PatchOneRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class PatchOneRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @coversDefaultClass PatchOneRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PatchOneRequestTest extends TestCase
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
        Phake::when($this->request)->getContent(Phake::anyParameters())->thenReturn(
            '{
            "entityId":"good",
            "sex":"F"
            }'
        );
        Phake::when($this->resolver)->resolve(Phake::anyParameters())->thenReturn(
            [
                'entityId' => 'good',
                'lastName' => null,
                'firstName' => null,
                'sex' => 'F',
                'birthday' => null,
                'email' => null,
                'phoneNumber1' => null,
                'phoneNumber2' => null,
                'salary' => null,
                'salaryCurrency' => null
            ]
        );
        $request = new PatchOneRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls();
        $this->verifySetAllowedTypesCalls(10);

        static::assertEquals('good', $params['entityId']);
        static::assertEquals(null, $params['lastName']);
        static::assertEquals(null, $params['firstName']);
        static::assertEquals('F', $params['sex']);
        static::assertEquals(null, $params['birthday']);
        static::assertEquals(null, $params['email']);
        static::assertEquals(null, $params['phoneNumber1']);
        static::assertEquals(null, $params['phoneNumber2']);
        static::assertEquals(null, $params['salary']);
        static::assertEquals(null, $params['salaryCurrency']);
    }

    /**
     * Tests firing the exception.
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\PresentationException
     */
    public function testExceptionBecauseInvalidJson(): void
    {
        Phake::when($this->request)->getContent()->thenReturn('{"an":"invalid json}');
        Phake::when($this->resolver)
            ->resolve(Phake::anyParameters())
            ->thenReturn(['entityIds' => ['good', 'johnny']]);
        new PatchOneRequest($this->request, $this->resolver);
    }
}
