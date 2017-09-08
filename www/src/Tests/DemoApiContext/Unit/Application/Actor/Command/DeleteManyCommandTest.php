<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\DeleteOneCommand;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class DeleteManyCommandTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command
 *
 * @coversDefaultClass DeleteManyCommand
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteManyCommandTest extends TestCase
{
    /** @var DeleteManyCommand $command */
    protected $command;

    /** @var DeleteOneCommand[] $oneCommands */
    protected $oneCommands;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->oneCommands = [
            new DeleteOneCommand('aaa'),
            new DeleteOneCommand('bbb'),
            new DeleteOneCommand('ccc'),
            new DeleteOneCommand('ddd'),
        ];
        $this->command = new DeleteManyCommand($this->oneCommands);
    }

    /**
     * Tests asserting Interface.
     *
     * @covers DeleteManyCommand::__construct()
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(CommandInterface::class, $this->command);
    }

    /**
     * Tests the getters.
     *
     * @covers AbstractDeleteManyCommand::getDeleteOneCommands()
     */
    public function testGetters(): void
    {
        static::assertEquals($this->oneCommands, $this->command->getDeleteOneCommands());
    }
}
