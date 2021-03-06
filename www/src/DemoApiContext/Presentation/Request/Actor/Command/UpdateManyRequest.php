<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Request\Actor\Command;

use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\AbstractUpdateManyRequest;

/**
 * Class UpdateManyRequest
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @license MIT
 */
class UpdateManyRequest extends AbstractUpdateManyRequest
{
    /**
     * @var array $defaults List of default values for optional parameters.
     */
    protected $defaults = [
        'phoneNumber2' => null,
    ];

    /**
     * @var string[] $required List of required parameters.
     */
    protected $required = [
        'entityId',
        'lastName',
        'firstName',
        'sex',
        'birthday',
        'email',
        'phoneNumber1',
        'salary',
        'salaryCurrency',
    ];

    /**
     * @var array[] $allowedTypes List of allowed types for each parameter.
     */
    protected $allowedTypes = [
        'entityId' => ['string'],
        'lastName' => ['string'],
        'firstName' => ['string'],
        'sex' => ['string'],
        'birthday' => ['string'],
        'email' => ['string'],
        'phoneNumber1' => ['string'],
        'phoneNumber2' => ['string', 'null'],
        'salary' => ['float'],
        'salaryCurrency' => ['string'],
    ];
}
