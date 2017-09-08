<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\UpdateManyCommand;
use DemoApiContext\Presentation\Adapter\Actor\Command\UpdateManyCommandAdapter;
use DemoApiContext\Presentation\Request\Actor\Command\UpdateManyRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class UpdateManyCommandAdapterTest
 * This class permits to test the UpdateManyCommandAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @coversDefaultClass UpdateManyCommandAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class UpdateManyCommandAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of UpdateManyRequest.
     * @see UpdateManyRequest
     */
    protected $request;

    /** @var UpdateManyCommandAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(UpdateManyRequest::class);
        Phake::when($this->request)->getRequestParameters()
            ->thenReturn(
                [
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
                    ],
                    [
                        'entityId' => 'bad',
                        'lastName' => 'dupont',
                        'firstName' => 'gerard',
                        'sex' => 'M',
                        'birthday' => '1999-04-01',
                        'email' => 'johnny@bad.com',
                        'phoneNumber1' => '0489541259',
                        'phoneNumber2' => '0665896321',
                        'salary' => 99.0,
                        'salaryCurrency' => 'EUR'
                    ]
                ]
            );
        $this->adapter = new UpdateManyCommandAdapter();
    }

    /**
     * Tests buildCommandFromRequest method.
     *
     * @covers ::buildCommandFromRequest()
     */
    public function testNominal(): void
    {
        $command = $this->adapter->buildCommandFromRequest($this->request);
        Phake::verify($this->request, Phake::times(1))->getRequestParameters(Phake::anyParameters());
        static::assertInstanceOf(CommandInterface::class, $command);
        static::assertInstanceOf(UpdateManyCommand::class, $command);
    }
}
