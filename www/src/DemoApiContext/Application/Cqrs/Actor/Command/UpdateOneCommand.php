<?php
declare(strict_types = 1);

namespace DemoApiContext\Application\Cqrs\Actor\Command;

use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\{AbstractUpdateOneCommand, TraitEntityIdCommand};

/**
 * Class UpdateOneCommand
 *
 * @category DemoApiContext
 * @package Application
 * @subpackage Cqrs\Actor\Command
 *
 * @license MIT
 */
class UpdateOneCommand extends AbstractUpdateOneCommand
{
    use TraitActorCommand;
    use TraitEntityIdCommand;

    /**
     * Constructs the UpdateOneCommand object.
     *
     * @param string $entityId
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
        string $entityId,
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
        $this->entityId = $entityId;
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
