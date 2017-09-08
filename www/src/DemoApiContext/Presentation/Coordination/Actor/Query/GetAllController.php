<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetAllQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Query\TraitGetAllController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareQueryBody\TraitGetAllBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetAllController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Query
 *
 * @license MIT
 */
final class GetAllController
{
    use TraitGetAllBody;
    use TraitGetAllController;

    /**
     * Processes the action "GetAll".
     *
     * @return Response
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Query.
        /** @var GetAllQuery $query */
        $query = $this->queryAdapter->buildQueryFromRequest($this->queryRequest);

        // 2. Business work thanks to the Query.
        $results = $this->queryHandler->process($query);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess($results, $query);
        return $this->responseHandler->create($body)->getResponse();
    }
}
