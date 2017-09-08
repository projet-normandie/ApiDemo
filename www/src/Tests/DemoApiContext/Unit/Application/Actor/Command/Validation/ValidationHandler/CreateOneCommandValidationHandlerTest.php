<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Application\Cqrs\Actor\Command\Validation\ValidationHandler;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use DemoApiContext\Application\Cqrs\Actor\Command\Validation\ValidationHandler\CreateOneCommandValidationHandler;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Validation\ValidationHandler\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class CreateOneCommandValidationHandlerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Application
 * @subpackage Actor\Command\Validation\ValidationHandler
 *
 * @coversDefaultClass CreateOneCommandValidationHandler
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateOneCommandValidationHandlerTest extends TestCase
{
    /** @var CreateOneCommandValidationHandler $validationHandler */
    protected $validationHandler;

    /**
     * @var Phake_IMock $validator Mock instance of ValidatorInterface.
     * @see ValidatorInterface
     */
    protected $validator;

    /**
     * @var Phake_IMock $command Mock instance of CreateOneCommand.
     * @see CreateOneCommand
     */
    protected $command;

    /**
     * @var Phake_IMock $errors Mock instance of ConstraintViolationListInterface.
     * @see ConstraintViolationListInterface
     */
    protected $errors;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->validator = Phake::mock(ValidatorInterface::class);
        $this->command = Phake::mock(CreateOneCommand::class);
        $this->validationHandler = new CreateOneCommandValidationHandler($this->validator);
        $this->errors = Phake::mock(ConstraintViolationListInterface::class);
    }

    /**
     * Tests a successful workflow.
     *
     * @covers AbstractCommandSpecHandler::process()
     */
    public function testValidData(): void
    {
        Phake::when($this->validator)->validateValue(Phake::anyParameters())->thenReturn($this->errors);
        Phake::when($this->errors)->count()->thenReturn(0);
        $result = $this->validationHandler->process($this->command);
        static::assertTrue($result);
    }

    /**
     * Tests throwing Exception.
     *
     * @expectedException \ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Exception\ValidationException
     */
    public function testInvalidName(): void
    {
        Phake::when($this->validator)->validateValue(Phake::anyParameters())->thenReturn($this->errors);
        Phake::when($this->errors)->count()->thenReturn(2);
        $this->validationHandler->process($this->command);
        $errors = $this->validationHandler->getErrors();
        static::assertCount(2, $errors);
    }
}
