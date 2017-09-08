<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor\Command;

use DemoApiContext\Presentation\Request\Actor\Command\UpdateManyRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Request\RequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Resolver\ResolverInterface;
use Tests\DemoApiContext\Unit\Presentation\Request\Actor\TraitVerifyResolver;

/**
 * Class UpdateManyRequestTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @coversDefaultClass UpdateManyRequest
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class UpdateManyRequestTest extends TestCase
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
                    "lastName":"de nil",
                    "firstName":"laurent",
                    "sex":"F",
                    "birthday":"2015-01-01",
                    "email":"johnny@good.com",
                    "phoneNumber1":"0134342233",
                    "phoneNumber2":"0612131415",
                    "salary": 100000.0,
                    "salaryCurrency":"EUR"
                },
                {
                    "entityId":"bad",
                    "lastName":"Giraud",
                    "firstName":"FirstName",
                    "sex":"M",
                    "birthday":"1999-04-01",
                    "email":"johnny@bad.com",
                    "phoneNumber1":"0988776655",
                    "phoneNumber2":"0611223344",
                    "salary": 10.0,
                    "salaryCurrency":"EUR"
                }
            ]'
        );
        Phake::when($this->resolver)->resolve(Phake::anyParameters())
            ->thenReturn(
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
            )->thenReturn(
                [
                    'entityId' => 'bad',
                    'lastName' => 'Giraud',
                    'firstName' => 'FirstName',
                    'sex' => 'M',
                    'birthday' => '1999-04-01',
                    'email' => 'johnny@bad.com',
                    'phoneNumber1' => '0988776655',
                    'phoneNumber2' => '0611223344',
                    'salary' => 10.0,
                    'salaryCurrency' => 'EUR'
                ]
            );
        $request = new UpdateManyRequest($this->request, $this->resolver);

        $params = $request->getRequestParameters();

        $this->verifySetDefaultsCalls();
        $this->verifySetRequiredCalls();
        $this->verifyResolveCalls(2);
        $this->verifySetAllowedTypesCalls(10);

        static::assertEquals('good', $params[0]['entityId']);
        static::assertEquals('de nil', $params[0]['lastName']);
        static::assertEquals('laurent', $params[0]['firstName']);
        static::assertEquals('F', $params[0]['sex']);
        static::assertEquals('2015-01-01', $params[0]['birthday']);
        static::assertEquals('johnny@good.com', $params[0]['email']);
        static::assertEquals('0134342233', $params[0]['phoneNumber1']);
        static::assertEquals('0612131415', $params[0]['phoneNumber2']);
        static::assertEquals('100000', $params[0]['salary']);
        static::assertEquals('EUR', $params[0]['salaryCurrency']);

        static::assertEquals('bad', $params[1]['entityId']);
        static::assertEquals('Giraud', $params[1]['lastName']);
        static::assertEquals('FirstName', $params[1]['firstName']);
        static::assertEquals('M', $params[1]['sex']);
        static::assertEquals('1999-04-01', $params[1]['birthday']);
        static::assertEquals('johnny@bad.com', $params[1]['email']);
        static::assertEquals('0988776655', $params[1]['phoneNumber1']);
        static::assertEquals('0611223344', $params[1]['phoneNumber2']);
        static::assertEquals('10', $params[1]['salary']);
        static::assertEquals('EUR', $params[1]['salaryCurrency']);
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
        new UpdateManyRequest($this->request, $this->resolver);
    }
}
