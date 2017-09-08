<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Coordination\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetByIdsQuery;
use DemoApiContext\Presentation\Coordination\Actor\Query\GetByIdsController;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryHandlerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\QueryAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Query\QueryRequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\ResponseHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetByIdsControllerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Coordination\Actor\Query
 *
 * @coversDefaultClass GetByIdsController
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class GetByIdsControllerTest extends TestCase
{
    /**
     * Adapter that will create the command from the request.
     * @var Phake_IMock $queryAdapter Mock instance of QueryAdapterInterface.
     * @see QueryAdapterInterface.
     */
    protected $queryAdapter;

    /**
     * Request object that is resolved from the request.
     * @var Phake_IMock $queryRequest Mock instance of QueryRequestInterface.
     * @see QueryRequestInterface.
     */
    protected $queryRequest;

    /**
     * Processes the business work.
     * @var Phake_IMock $queryHandler Mock instance of QueryHandlerInterface.
     * @see QueryHandlerInterface.
     */
    protected $queryHandler;

    /**
     * Formatter of the response.
     * @var Phake_IMock $responseHandler Mock instance of ResponseHandlerInterface.
     * @see ResponseHandlerInterface.
     */
    protected $responseHandler;

    /** @var GetByIdsController $controller */
    protected $controller;

    /**
     * Configures the test.
     */
    public function setUp(): void
    {
        $this->queryAdapter = Phake::mock(QueryAdapterInterface::class);
        $this->queryRequest = Phake::mock(QueryRequestInterface::class);
        $this->queryHandler = Phake::mock(QueryHandlerInterface::class);
        $this->responseHandler = Phake::mock(ResponseHandlerInterface::class);

        $this->controller = new GetByIdsController(
            $this->queryAdapter,
            $this->queryRequest,
            $this->queryHandler,
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
        $getByIdsQuery = Phake::mock(GetByIdsQuery::class);
        Phake::when($this->queryAdapter)
            ->buildQueryFromRequest(Phake::anyParameters())
            ->thenReturn($getByIdsQuery);

        Phake::when($this->responseHandler)
            ->create(Phake::anyParameters())
            ->thenReturn($this->responseHandler);

        Phake::when($this->queryHandler)
            ->process($getByIdsQuery)
            ->thenReturn([]);

        Phake::when($this->responseHandler)
            ->getResponse(Phake::anyParameters())
            ->thenReturn(Phake::mock(Response::class));

        $response = $this->controller->processAction();

        Phake::verify($this->queryAdapter, Phake::times(1))->buildQueryFromRequest(Phake::anyParameters());
        Phake::verify($this->queryHandler, Phake::times(1))->process(Phake::anyParameters());
        Phake::verify($this->responseHandler, Phake::times(1))->create(Phake::anyParameters());
        Phake::verify($this->responseHandler, Phake::times(1))->getResponse(Phake::anyParameters());
        static::assertInstanceOf(Response::class, $response);
    }
}
