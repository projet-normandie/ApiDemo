<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Request\Actor\Command;

use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\AbstractPatchManyRequest;

/**
 * Class PatchManyRequest
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Request\Actor\Command
 *
 * @license MIT
 */
class PatchManyRequest extends AbstractPatchManyRequest
{
    /**
     * @var array $defaults List of default values for optional parameters.
     */
    protected $defaults = [
        'lastName' => null,
        'firstName' => null,
        'sex' => null,
        'birthday' => null,
        'email' => null,
        'phoneNumber1' => null,
        'phoneNumber2' => null,
        'salary' => null,
        'salaryCurrency' => null,
    ];

    /**
     * @var string[] $required List of required parameters.
     */
    protected $required = [
        'entityId',
    ];

    /**
     * @var array[] $allowedTypes List of allowed types for each parameter.
     */
    protected $allowedTypes = [
        'entityId' => ['string'],
        'lastName' => ['string', 'null'],
        'firstName' => ['string', 'null'],
        'sex' => ['string', 'null'],
        'birthday' => ['string', 'null'],
        'email' => ['string', 'null'],
        'phoneNumber1' => ['string', 'null'],
        'phoneNumber2' => ['string', 'null'],
        'salary' => ['float', 'null'],
        'salaryCurrency' => ['string', 'null'],
    ];
}
