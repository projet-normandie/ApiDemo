<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\AbstractCommand;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;

/**
 * Class CreateOneCommandTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command
 *
 * @coversDefaultClass CreateOneCommand
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateOneCommandTest extends TestCase
{
    /** @var CreateOneCommand $command */
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
        $this->lastName = 'good';
        $this->firstName = 'dark';
        $this->sex = 'M';
        $this->birthday = '20/12/1950';
        $this->email = 'johnny@good.com';
        $this->phoneNumber1 = '0147474747';
        $this->phoneNumber2 = null;
        $this->salary = 40000.0;
        $this->salaryCurrency = 'EUR';
        $this->command = new CreateOneCommand(
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
     * @covers CreateOneCommand::__construct()
     */
    public function testInterface(): void
    {
        static::assertInstanceOf(CommandInterface::class, $this->command);
    }

    /**
     * Tests the Getters.
     *
     * @covers TraitActorCommand::getLastName()
     * @covers TraitActorCommand::getFirstName()
     * @covers TraitActorCommand::getSex()
     * @covers TraitActorCommand::getBirthday()
     * @covers TraitActorCommand::getEmail()
     * @covers TraitActorCommand::getPhoneNumber1()
     * @covers TraitActorCommand::getPhoneNumber2()
     * @covers TraitActorCommand::getSalary()
     * @covers TraitActorCommand::getSalaryCurrency()
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
            'lastName' => 'good',
            'firstName' => 'dark',
            'sex' => 'M',
            'birthday' => '20/12/1950',
            'email' => 'johnny@good.com',
            'phoneNumber1' => '0147474747',
            'phoneNumber2' => null,
            'salary' => 40000.0,
            'salaryCurrency' => 'EUR'
        ];
        static::assertEquals($expected, $this->command->toArray());
    }

    /**
     * Tests testToArray method with $skipNull = true.
     *
     * @covers AbstractCommand::toArray()
     */
    public function testToArraySkipNull(): void
    {
        $expected = [
            'lastName' => 'good',
            'firstName' => 'dark',
            'sex' => 'M',
            'birthday' => '20/12/1950',
            'email' => 'johnny@good.com',
            'phoneNumber1' => '0147474747',
            'salary' => 40000.0,
            'salaryCurrency' => 'EUR'
        ];
        static::assertEquals($expected, $this->command->toArray(true));
    }
}
