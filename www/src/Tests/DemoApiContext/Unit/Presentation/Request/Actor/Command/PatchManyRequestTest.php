<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Command;

use DemoApiContext\Presentation\Request\Actor\Command\PatchManyRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class PatchManyRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @coversDefaultClass PatchManyRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PatchManyRequestTest extends TestCase
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
            '[
                {
                    "entityId":"good",
                    "firstName":"Nicolas"
                },
                {
                    "entityId":"bad",
                    "firstName":"Hugues"
                }
            ]'
        );
        Phake::when($this->resolver)->resolve(Phake::anyParameters())
            ->thenReturn(
                [
                    'entityId' => 'good',
                    'lastName' => null,
                    'firstName' => 'Nicolas',
                    'sex' => null,
                    'birthday' => null,
                    'email' => null,
                    'phoneNumber1' => null,
                    'phoneNumber2' => null,
                    'salary' => null,
                    'salaryCurrency' => null
                ]
            )->thenReturn(
                [
                    'entityId' => 'bad',
                    'lastName' => null,
                    'firstName' => 'Hugues',
                    'sex' => null,
                    'birthday' => null,
                    'email' => null,
                    'phoneNumber1' => null,
                    'phoneNumber2' => null,
                    'salary' => null,
                    'salaryCurrency' => null
                ]
            );
        $request = new PatchManyRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls(2);
        $this->verifySetAllowedTypesCalls(10);

        static::assertEquals('good', $params[0]['entityId']);
        static::assertEquals('Nicolas', $params[0]['firstName']);

        static::assertEquals('bad', $params[1]['entityId']);
        static::assertEquals('Hugues', $params[1]['firstName']);
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
        new PatchManyRequest($this->request, $this->resolver);
    }
}
