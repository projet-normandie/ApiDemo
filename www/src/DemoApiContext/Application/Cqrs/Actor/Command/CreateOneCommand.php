<?php
declare(strict_types = 1);

namespace DemoApiContext\Application\Cqrs\Actor\Command;

use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\AbstractCreateOneCommand;

/**
 * Class CreateOneCommand
 *
 * @category DemoApiContext
 * @package Application
 * @subpackage Cqrs\Actor\Command
 *
 * @license MIT
 */
class CreateOneCommand extends AbstractCreateOneCommand
{
    use TraitActorCommand;

    /**
     * Constructs the CreateOneCommand object.
     *
     * @param string $lastName
     * @param string $firstName
     * @param string $sex
     * @param string $birthday
     * @param string $email
     * @param string $phoneNumber1
     * @param string|null $phoneNumber2
     * @param float $salary
     * @param string $salaryCurrency
     */
    public function __construct(
        string $lastName,
        string $firstName,
        string $sex,
        string $birthday,
        string $email,
        string $phoneNumber1,
        string $phoneNumber2 = null,
        float $salary,
        string $salaryCurrency
    ) {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->sex = $sex;
        $this->birthday = $birthday;
        $this->email = $email;
        $this->phoneNumber1 = $phoneNumber1;
        $this->phoneNumber2 = $phoneNumber2;
        $this->salary = $salary;
        $this->salaryCurrency = $salaryCurrency;
    }
}
