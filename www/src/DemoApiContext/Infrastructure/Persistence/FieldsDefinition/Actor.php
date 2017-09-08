<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Persistence\FieldsDefinition;

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\FieldsDefinition\FieldsDefinitionAbstract;

/**
 * Class Actor
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Persistence\FieldsDefinition
 *
 * @license MIT
 */
class Actor extends FieldsDefinitionAbstract
{
    /**
     * @var string[] Associative array where keys are parameters names from the request and values are db fields names.
     */
    protected $fields = [
        'lastName' => 'actor.profile.lastName',
        'firstName' => 'actor.profile.firstName',
        'sex' => 'actor.situation.sex',
        'birthday' => 'actor.situation.birthday',
        'email' => 'actor.contact.email',
        'phoneNumber1' => 'actor.contact.phoneNumber1',
        'phoneNumber2' => 'actor.contact.phoneNumber2',
        'salary' => 'actor.salary.value',
        'salaryCurrency' => 'actor.salary.currency'
    ];
}
