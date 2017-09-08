<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\UpdateManyCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\UpdateOneCommand;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\AbstractCommand;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class UpdateManyCommandTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command
 *
 * @coversDefaultClass UpdateManyCommand
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class UpdateManyCommandTest extends TestCase
{
    /** @var string $entityId */
    protected $entityId;

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

    /** @var UpdateManyCommand $command */
    protected $command;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->entityId = '1234567890';
        $this->lastName = 'good';
        $this->firstName = 'dark';
        $this->sex = 'M';
        $this->birthday = '20/12/1950';
        $this->email = 'dark@good.com';
        $this->phoneNumber1 = '0147474747';
        $this->phoneNumber2 = null;
        $this->salary = 40000.0;
        $this->salaryCurrency = 'EUR';
        $oneCommand = new UpdateOneCommand(
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

        $this->command = new UpdateManyCommand([$oneCommand, $oneCommand]);
    }

    /**
     * Tests asserting Interface.
     *
     * @covers UpdateManyCommand::__construct()
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(CommandInterface::class, $this->command);
    }

    /**
     * Tests the getters
     */
    public function testGetters(): void
    {
        /** @var UpdateOneCommand $oneCommand */
        $oneCommand = $this->command->getByIndex(0);
        static::assertEquals($this->entityId, $oneCommand->getEntityId());
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
            [
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
            ],
            [
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
            ]
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
            [
                'entityId' => $this->entityId,
                'lastName' => $this->lastName,
                'firstName' => $this->firstName,
                'sex' => $this->sex,
                'birthday' => $this->birthday,
                'email' => $this->email,
                'phoneNumber1' => $this->phoneNumber1,
                'salary' => $this->salary,
                'salaryCurrency' => $this->salaryCurrency,
            ],
            [
                'entityId' => $this->entityId,
                'lastName' => $this->lastName,
                'firstName' => $this->firstName,
                'sex' => $this->sex,
                'birthday' => $this->birthday,
                'email' => $this->email,
                'phoneNumber1' => $this->phoneNumber1,
                'salary' => $this->salary,
                'salaryCurrency' => $this->salaryCurrency,
            ]
        ];
        static::assertEquals($expected, $this->command->toArray(true));
    }
}
