<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command\Handler\Decorator;

use DemoApiContext\Application\Cqrs\Actor\Command\Handler\Decorator\CreateManyCommandHandlerDecorator;

/**
 * Class CreateManyCommandHandlerDecoratorTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command\Handler\Decorator
 *
 * @coversDefaultClass CreateManyCommandHandlerDecorator
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateManyCommandHandlerDecoratorTest extends AbstractCommandHandlerDecoratorTest
{
    /**
     * Initiates the test.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->decorator = new CreateManyCommandHandlerDecorator(
            $this->commandHandler,
            $this->validationHandler,
            $this->specHandler
        );
    }
}
