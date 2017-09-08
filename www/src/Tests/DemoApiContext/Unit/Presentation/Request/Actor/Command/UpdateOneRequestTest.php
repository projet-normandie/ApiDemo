<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Command;

use DemoApiContext\Presentation\Request\Actor\Command\UpdateOneRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class UpdateOneRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @coversDefaultClass UpdateOneRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class UpdateOneRequestTest extends TestCase
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
            "lastName":"de nil",
            "firstName":"laurent",
            "sex":"F",
            "birthday":"2015-01-01",
            "email":"johnny@good.com",
            "phoneNumber1":"0134342233",
            "phoneNumber2":"0612131415",
            "salary": 100000.0,
            "salaryCurrency":"EUR"
            }'
        );
        Phake::when($this->resolver)->resolve(Phake::anyParameters())->thenReturn(
            [
                'entityId' => 'good',
                'lastName' => 'de nil',
                'firstName' => 'laurent',
                'sex' => 'F',
                'birthday' => '2015-01-01',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0134342233',
                'phoneNumber2' => '0612131415',
                'salary' => 100000.0,
                'salaryCurrency' => 'EUR'
            ]
        );
        $request = new UpdateOneRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls();
        $this->verifySetAllowedTypesCalls(10);

        static::assertEquals('good', $params['entityId']);
        static::assertEquals('de nil', $params['lastName']);
        static::assertEquals('laurent', $params['firstName']);
        static::assertEquals('F', $params['sex']);
        static::assertEquals('2015-01-01', $params['birthday']);
        static::assertEquals('johnny@good.com', $params['email']);
        static::assertEquals('0134342233', $params['phoneNumber1']);
        static::assertEquals('0612131415', $params['phoneNumber2']);
        static::assertEquals('100000', $params['salary']);
        static::assertEquals('EUR', $params['salaryCurrency']);
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
        new UpdateOneRequest($this->request, $this->resolver);
    }
}
