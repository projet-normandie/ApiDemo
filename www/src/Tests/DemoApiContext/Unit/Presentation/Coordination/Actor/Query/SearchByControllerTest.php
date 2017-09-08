<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Coordination\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\SearchByQuery;
use DemoApiContext\Presentation\Coordination\Actor\Query\SearchByController;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\QueryHandlerInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\QueryAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Criteria;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\Limit;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\CustomType\OrderBy;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Query\QueryRequestInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\ResponseHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SearchByControllerTest
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Coordination\Actor\Query
 *
 * @coversDefaultClass SearchByController
 * @group unit
 * @requires PHP 7.0
 *
 * @license MIT
 */
class SearchByControllerTest extends TestCase
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

    /** @var SearchByController $controller */
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

        $this->controller = new SearchByController(
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
        $getAllQuery = Phake::mock(SearchByQuery::class);

        $criteria = Phake::mock(Criteria::class);
        $limit = Phake::mock(Limit::class);
        $orderBy = Phake::mock(OrderBy::class);

        Phake::when($getAllQuery)->getCriteria()->thenReturn($criteria);
        Phake::when($getAllQuery)->getLimit()->thenReturn($limit);
        Phake::when($getAllQuery)->getOrderBy()->thenReturn($orderBy);

        Phake::when($this->queryAdapter)
            ->buildQueryFromRequest(Phake::anyParameters())
            ->thenReturn($getAllQuery);

        Phake::when($this->responseHandler)
            ->create(Phake::anyParameters())
            ->thenReturn($this->responseHandler);

        $result = ['total_rows' => 0, 'results' => null];
        Phake::when($this->queryHandler)
            ->process($getAllQuery)
            ->thenReturn($result);

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
