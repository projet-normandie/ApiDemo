<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\AbstractCommand;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class PatchManyCommandTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command
 *
 * @coversDefaultClass PatchManyCommand
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class PatchManyCommandTest extends TestCase
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

    /** @var PatchManyCommand $command */
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
        $oneCommand = new PatchOneCommand(
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

        $this->command = new PatchManyCommand([$oneCommand, $oneCommand]);
    }

    /**
     * Tests asserting Interface.
     *
     * @covers PatchManyCommand::__construct()
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(CommandInterface::class, $this->command);
    }

    /**
     * Tests the getters
     *
     * @covers PatchManyCommand::__construct()
     */
    public function testGetters(): void
    {
        /** @var PatchOneCommand $oneCommand */
        $oneCommand = $this->command->getByIndex(0);
        static::assertEquals($this->lastName, $oneCommand->getLastName());
        static::assertEquals($this->firstName, $oneCommand->getFirstName());
        static::assertEquals($this->sex, $oneCommand->getSex());
        static::assertEquals($this->birthday, $oneCommand->getBirthday());
        static::assertEquals($this->email, $oneCommand->getEmail());
        static::assertEquals($this->phoneNumber1, $oneCommand->getPhoneNumber1());
        static::assertEquals($this->phoneNumber2, $oneCommand->getPhoneNumber2());
        static::assertEquals($this->salary, $oneCommand->getSalary());
        static::assertEquals($this->salaryCurrency, $oneCommand->getSalaryCurrency());
    }

    /**
     * Tests toArray method.
     *
     * @covers AbstractCommand::toArray()
     */
    public function testToArray(): void
    {
        $expected = [
            'entityId' => $this->entityId,
            'lastName' => $this->lastName,
            'firstName' => $this->firstName,
            'sex' => $this->sex,
            'birthday' => $this->birthday,
            'email' => $this->email,
            'phoneNumber1' => $this->phoneNumber1,
            'phoneNumber2' => $this->phoneNumber2,
            'salary' => $this->salary,
            'salaryCurrency' => $this->salaryCurrency,
        ];
        static::assertEquals([$expected, $expected], $this->command->toArray());
    }

    /**
     * Tests toArray method with $skipNull = true.
     *
     * @covers AbstractCommand::toArray()
     */
    public function testToArraySkipNull(): void
    {
        $expected = [
            'entityId' => $this->entityId,
            'sex' => $this->sex,
        ];
        static::assertEquals([$expected, $expected], $this->command->toArray(true));
    }
}
