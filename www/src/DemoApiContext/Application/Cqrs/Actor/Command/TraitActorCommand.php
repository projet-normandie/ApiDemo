<?php
declare(strict_types = 1);

namespace DemoApiContext\Application\Cqrs\Actor\Command;

/**
 * Trait TraitActorCommand
 * Contains all properties of an entity Actor without its ID.
 *
 * @category DemoApiContext
 * @package Application
 * @subpackage Cqrs\Actor\Command
 *
 * @license MIT
 */
trait TraitActorCommand
{
    /**
     * @var string Last name of the actor.
     */
    protected $lastName;

    /**
     * @var string First name of the actor.
     */
    protected $firstName;

    /**
     * @var string Gender of the actor. Should be only "M" for "male" of "F" for "female".
     */
    protected $sex;

    /**
     * @var string Birthday date of the actor. Must be a valid string date.
     */
    protected $birthday;

    /**
     * @var string Email address of the actor.
     */
    protected $email;

    /**
     * @var string First phone number of the actor.
     */
    protected $phoneNumber1;

    /**
     * @var string Second phone number of the actor.
     */
    protected $phoneNumber2;

    /**
     * @var float Salary value of the actor.
     */
    protected $salary;

    /**
     * @var string Currency of the salary of the actor.
     */
    protected $salaryCurrency;


    /**
     * Returns the lastName of the Actor.
     *
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Returns the firstName of the Actor.
     *
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Returns the sex of the Actor.
     *
     * @return null|string
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * Returns the birthday of the Actor.
     *
     * @return null|string
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * Returns the email of the Actor.
     *
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Returns the phoneNumber1 of the Actor.
     *
     * @return null|string
     */
    public function getPhoneNumber1(): ?string
    {
        return $this->phoneNumber1;
    }

    /**
     * Returns the phoneNumber2 of the Actor.
     *
     * @return null|string
     */
    public function getPhoneNumber2(): ?string
    {
        return $this->phoneNumber2;
    }

    /**
     * Returns the salary of the Actor.
     *
     * @return null|float
     */
    public function getSalary(): ?float
    {
        return $this->salary;
    }

    /**
     * Returns the salaryCurrency of the Actor.
     *
     * @return null|string
     */
    public function getSalaryCurrency(): ?string
    {
        return $this->salaryCurrency;
    }
}
