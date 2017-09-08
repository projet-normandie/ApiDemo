<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class CreateManyCommandTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command
 *
 * @coversDefaultClass CreateManyCommand
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateManyCommandTest extends TestCase
{
    /** @var CreateOneCommand[] */
    protected $commands = [];

    /** @var CreateManyCommand $command */
    protected $command;

    /** @var string $lastName */
    protected $lastName;

    /** @var string $firstName */
    protected $firstName;

    /** @var string $sex */
    protected $sex;

    /** @var string $birthday */
    protected $birthday;

    /** @var string $email */
    protected $email;

    /** @var string $phoneNumber1 */
    protected $phoneNumber1;

    /** @var string|null $phoneNumber2 */
    protected $phoneNumber2;

    /** @var float $salary */
    protected $salary;

    /** @var string $salaryCurrency */
    protected $salaryCurrency;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->lastName = 'good' . $i;
            $this->firstName = 'johnny';
            $this->sex = 'M';
            $this->birthday = '20/12/1950';
            $this->email = 'johnny@good.com';
            $this->phoneNumber1 = '0147474747';
            $this->phoneNumber2 = '';
            $this->salary = 40000.0;
            $this->salaryCurrency = 'EUR';
            $this->commands[] = new CreateOneCommand(
                $this->lastName,
                $this->firstName,
                $this->sex,
                $this->birthday,
                $this->email,
                $this->phoneNumber1,
                $this->phoneNumber2,
                $this->salary,
                $this->salaryCurrency
            );
        }
        $this->command = new CreateManyCommand($this->commands);
    }

    /**
     * Tests asserting Interface.
     *
     * @covers CreateManyCommand::__construct()
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(CommandInterface::class, $this->command);
    }

    /**
     * Tests getCreateOneCommands method.
     *
     * @covers AbstractCreateManyCommand::getCreateOneCommands()
     */
    public function testGetCreateOneCommands(): void
    {
        $result = $this->command->getCreateOneCommands();
        static::assertTrue(\is_array($result));
        static::assertEquals(\count($this->commands), \count($result));
        foreach ($result as $createCommand) {
            static::assertInstanceOf(CreateOneCommand::class, $createCommand);
        }
    }

    /**
     * Tests getByIndex method.
     *
     * @covers AbstractCreateManyCommand::getByIndex()
     */
    public function testGetByIndex(): void
    {
        for ($i = 0; $i < 5; $i++) {
            /** @var CreateOneCommand $result */
            $result = $this->command->getByIndex($i);
            static::assertEquals('good' . $i, $result->getLastName());
            static::assertInstanceOf(CreateOneCommand::class, $result);
        }
    }

    /**
     * Tests toArray method.
     *
     * @covers AbstractCreateManyCommand::toArray()
     */
    public function testToArray(): void
    {
        $expected = [
            [
                'lastName' => 'good0',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'phoneNumber2' => null,
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good1',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'phoneNumber2' => null,
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good2',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'phoneNumber2' => null,
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good3',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'phoneNumber2' => null,
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good4',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'phoneNumber2' => null,
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ]
        ];
        static::assertEquals($expected, $this->command->toArray());
    }

    /**
     * Tests toArray method with $skipNull = true.
     *
     * @covers AbstractCreateManyCommand::toArray()
     */
    public function testToArraySkipNull(): void
    {
        $expected = [
            [
                'lastName' => 'good0',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good1',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good2',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good3',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ],
            [
                'lastName' => 'good4',
                'firstName' => 'johnny',
                'sex' => 'M',
                'birthday' => '20/12/1950',
                'email' => 'johnny@good.com',
                'phoneNumber1' => '0147474747',
                'salary' => 40000.0,
                'salaryCurrency' => 'EUR'
            ]
        ];
        static::assertEquals($expected, $this->command->toArray(true));
    }
}
