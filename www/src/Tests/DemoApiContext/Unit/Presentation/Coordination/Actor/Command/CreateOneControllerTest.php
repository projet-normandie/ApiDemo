<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use DemoApiContext\Presentation\Coordination\Actor\Command\CreateOneController;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandHandlerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\CommandAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\CommandRequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\ResponseHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateOneControllerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @coversDefaultClass CreateOneController
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class CreateOneControllerTest extends TestCase
{
    /**
     * Adapter that will create the command from the request.
     * @var Phake_IMock $commandAdapter Mock instance of CommandAdapterInterface.
     * @see CommandAdapterInterface.
     */
    protected $commandAdapter;

    /**
     * Request object that is resolved from the request.
     * @var Phake_IMock $commandRequest Mock instance of CommandRequestInterface.
     * @see CommandRequestInterface.
     */
    protected $commandRequest;

    /**
     * Processes the business work.
     * @var Phake_IMock $commandHandler Mock instance of CommandHandlerInterface.
     * @see CommandHandlerInterface.
     */
    protected $commandHandler;

    /**
     * Formatter of the response.
     * @var Phake_IMock $responseHandler Mock instance of ResponseHandlerInterface.
     * @see ResponseHandlerInterface.
     */
    protected $responseHandler;

    /** @var CreateOneController $controller */
    protected $controller;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->commandAdapter = Phake::mock(CommandAdapterInterface::class);
        $this->commandRequest = Phake::mock(CommandRequestInterface::class);
        $this->commandHandler = Phake::mock(CommandHandlerInterface::class);
        $this->responseHandler = Phake::mock(ResponseHandlerInterface::class);

        $this->controller = new CreateOneController(
            $this->commandAdapter,
            $this->commandRequest,
            $this->commandHandler,
            $this->responseHandler
        );
    }

    /**
     * Tests processAction method.
     *
     * @covers ::processAction()
     */
    public function testProcessAction(): void
    {
        $createOneCommand = Phake::mock(CreateOneCommand::class);
        Phake::when($this->commandAdapter)
            ->buildCommandFromRequest(Phake::anyParameters())
            ->thenReturn($createOneCommand);

        Phake::when($this->responseHandler)
            ->create(Phake::anyParameters())
            ->thenReturn($this->responseHandler);

        Phake::when($this->responseHandler)
            ->getResponse(Phake::anyParameters())
            ->thenReturn(Phake::mock(Response::class));

        $response = $this->controller->processAction();

        Phake::verify($this->commandAdapter, Phake::times(1))->buildCommandFromRequest(Phake::anyParameters());
        Phake::verify($this->commandHandler, Phake::times(1))->process(Phake::anyParameters());
        Phake::verify($this->responseHandler, Phake::times(1))->create(Phake::anyParameters());
        Phake::verify($this->responseHandler, Phake::times(1))->getResponse(Phake::anyParameters());
        static::assertInstanceOf(Response::class, $response);
    }
}
