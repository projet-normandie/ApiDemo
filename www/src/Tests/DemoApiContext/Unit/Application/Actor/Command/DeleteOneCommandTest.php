<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteOneCommand;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class DeleteOneCommandTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command
 *
 * @coversDefaultClass DeleteOneCommand
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class DeleteOneCommandTest extends TestCase
{
    /**
     * @var DeleteOneCommand
     */
    protected $command;

    /**
     * @var string
     */
    protected $id;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->id = '1111111';
        $this->command = new DeleteOneCommand($this->id);
    }

    /**
     * Tests asserting Interface.
     *
     * @covers DeleteOneCommand::__construct()
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(CommandInterface::class, $this->command);
    }

    /**
     * Tests the getters.
     *
     * @covers AbstractDeleteOneCommand::getEntityId()
     */
    public function testGetters(): void
    {
        static::assertEquals($this->id, $this->command->getEntityId());
    }
}
