<?php
declare(strict_types = 1);

namespace DemoApiContext\Application\Cqrs\Actor\Command\Validation\ValidationHandler;

use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Validation\ValidationHandler\{
    AbstractCreateManyCommandValidationHandler
};
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Validator\Constraint\Name;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Validator\Constraint\PhoneNumber;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Validator\Constraint\Sex;
use Symfony\Component\Validator\Constraints\Currency;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Exception\{
    ConstraintDefinitionException, InvalidOptionsException, MissingOptionsException
};

/**
 * Class CreateManyCommandValidationHandler
 *
 * @category DemoApiContext
 * @package Application
 * @subpackage Cqrs\Actor\Command\Validation\ValidationHandler
 *
 * @license MIT
 */
class CreateManyCommandValidationHandler extends AbstractCreateManyCommandValidationHandler
{
    /**
     * Initializes the basics constraints validation for each property of the CreateMany command.
     *
     * @throws ConstraintDefinitionException
     * @throws InvalidOptionsException
     * @throws MissingOptionsException
     */
    protected function initConstraints(): void
    {
        $this
            ->add('lastName', new Name())
            ->add('firstName', new Name())
            ->add('sex', new Sex())
            ->add('birthday', new Date())
            ->add('email', new Email())
            ->add('phoneNumber1', new PhoneNumber())
            ->add('phoneNumber2', new Optional(new PhoneNumber()))
            ->add('salary', new GreaterThanOrEqual(['value' => 0]))
            ->add('salaryCurrency', new Currency());
    }
}
