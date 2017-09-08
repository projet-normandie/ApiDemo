<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateManyCommand;
use DemoApiContext\Presentation\Adapter\Actor\Command\CreateManyCommandAdapter;
use DemoApiContext\Presentation\Request\Actor\Command\CreateManyRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class CreateManyCommandAdapterTest
 * This class permits to test the CreateManyCommandAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @coversDefaultClass CreateManyCommandAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateManyCommandAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of CreateManyRequest.
     * @see CreateManyRequest
     */
    protected $request;

    /** @var CreateManyCommandAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(CreateManyRequest::class);
        Phake::when($this->request)->getRequestParameters()
            ->thenReturn(
                [
                    [
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
                ]
            );
        $this->adapter = new CreateManyCommandAdapter();
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
        static::assertInstanceOf(CreateManyCommand::class, $command);
    }
}
