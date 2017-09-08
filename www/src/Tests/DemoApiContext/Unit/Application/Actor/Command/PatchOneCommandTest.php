<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\AbstractCommand;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class PatchOneCommandTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command
 *
 * @coversDefaultClass PatchOneCommand
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PatchOneCommandTest extends TestCase
{
    /** @var string $entityId */
    protected $entityId;

    /** @var string|null $lastName */
    protected $lastName;

    /** @var string|null $firstName */
    protected $firstName;

    /** @var string|null $sex */
    protected $sex;

    /** @var string|null $birthday */
    protected $birthday;

    /** @var string|null $email */
    protected $email;

    /** @var string|null $phoneNumber1 */
    protected $phoneNumber1;

    /** @var string|null $phoneNumber2 */
    protected $phoneNumber2;

    /** @var float|null $salary */
    protected $salary;

    /** @var string|null $salaryCurrency */
    protected $salaryCurrency;

    /** @var PatchOneCommand $command */
    protected $command;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->entityId = 'someId';
        $this->lastName = null;
        $this->firstName = null;
        $this->sex = 'M';
        $this->birthday = null;
        $this->email = null;
        $this->phoneNumber1 = null;
        $this->phoneNumber2 = null;
        $this->salary = null;
        $this->salaryCurrency = null;
        $this->command = new PatchOneCommand(
            $this->entityId,
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

    /**
     * Tests asserting Interface.
     *
     * @covers PatchOneCommand::__construct()
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(CommandInterface::class, $this->command);
    }

    /**
     * Tests the getters
     *
     * @covers PatchOneCommand::__construct()
     */
    public function testGetters(): void
    {
        static::assertEquals($this->lastName, $this->command->getLastName());
        static::assertEquals($this->firstName, $this->command->getFirstName());
        static::assertEquals($this->sex, $this->command->getSex());
        static::assertEquals($this->birthday, $this->command->getBirthday());
        static::assertEquals($this->email, $this->command->getEmail());
        static::assertEquals($this->phoneNumber1, $this->command->getPhoneNumber1());
        static::assertEquals($this->phoneNumber2, $this->command->getPhoneNumber2());
        static::assertEquals($this->salary, $this->command->getSalary());
        static::assertEquals($this->salaryCurrency, $this->command->getSalaryCurrency());
    }

    /**
     * Tests toArray method.
     *
     * @covers AbstractCommand::toArray()
     */
    public function testToArray(): void
    {
        $expected = [
            'entityId' => 'someId',
            'lastName' => null,
            'firstName' => null,
            'sex' => 'M',
            'birthday' => null,
            'email' => null,
            'phoneNumber1' => null,
            'phoneNumber2' => null,
            'salary' => null,
            'salaryCurrency' => null,
        ];
        static::assertEquals($expected, $this->command->toArray());
    }

    /**
     * Tests toArray method with $skipNull = true.
     *
     * @covers AbstractCommand::toArray()
     */
    public function testToArraySkipNull(): void
    {
        $expected = [
            'entityId' => 'someId',
            'sex' => 'M',
        ];
        static::assertEquals($expected, $this->command->toArray(true));
    }
}
