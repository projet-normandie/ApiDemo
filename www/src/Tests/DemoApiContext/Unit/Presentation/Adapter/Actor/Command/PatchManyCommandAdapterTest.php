<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchManyCommand;
use DemoApiContext\Presentation\Adapter\Actor\Command\PatchManyCommandAdapter;
use DemoApiContext\Presentation\Request\Actor\Command\PatchManyRequest;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class PatchManyCommandAdapterTest
 * This class permits to test the PatchManyCommandAdapter class.
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @coversDefaultClass PatchManyCommandAdapter
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PatchManyCommandAdapterTest extends TestCase
{
    /**
     * @var Phake_IMock $request Mock instance of PatchManyRequest.
     * @see PatchManyRequest
     */
    protected $request;

    /** @var PatchManyCommandAdapter $adapter */
    protected $adapter;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->request = Phake::mock(PatchManyRequest::class);
        Phake::when($this->request)->getRequestParameters()
            ->thenReturn(
                [
                    [
                        'entityId' => 'good',
                        'lastName' => null,
                        'firstName' => 'laurent',
                        'sex' => null,
                        'birthday' => null,
                        'email' => null,
                        'phoneNumber1' => null,
                        'phoneNumber2' => null,
                        'salary' => null,
                        'salaryCurrency' => null
                    ],
                    [
                        'entityId' => 'bad',
                        'lastName' => null,
                        'firstName' => 'gerard',
                        'sex' => 'M',
                        'birthday' => null,
                        'email' => null,
                        'phoneNumber1' => null,
                        'phoneNumber2' => null,
                        'salary' => 99.0,
                        'salaryCurrency' => null
                    ]
                ]
            );
        $this->adapter = new PatchManyCommandAdapter();
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
        static::assertInstanceOf(PatchManyCommand::class, $command);
    }
}
