<?php
declare(strict_types = 1);

namespace DemoApiContext\Application\Cqrs\Actor\Command;

use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Command\{AbstractPatchOneCommand, TraitEntityIdCommand};

/**
 * Class PatchOneCommand
 *
 * @category DemoApiContext
 * @package Application
 * @subpackage Cqrs\Actor\Command
 *
 * @license MIT
 */
class PatchOneCommand extends AbstractPatchOneCommand
{
    use TraitActorCommand;
    use TraitEntityIdCommand;

    /**
     * Constructs the PatchOneCommand object.
     *
     * @param string $entityId
     * @param string|null $lastName
     * @param string|null $firstName
     * @param string|null $sex
     * @param string|null $birthday
     * @param string|null $email
     * @param string|null $phoneNumber1
     * @param string|null $phoneNumber2
     * @param float|null $salary
     * @param string|null $salaryCurrency
     */
    public function __construct(
        string $entityId,
        string $lastName = null,
        string $firstName = null,
        string $sex = null,
        string $birthday = null,
        string $email = null,
        string $phoneNumber1 = null,
        string $phoneNumber2 = null,
        float $salary = null,
        string $salaryCurrency = null
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
