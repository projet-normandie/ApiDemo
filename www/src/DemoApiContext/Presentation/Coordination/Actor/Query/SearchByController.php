<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\SearchByQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Query\TraitSearchByController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareQueryBody\TraitSearchByBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SearchByController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Query
 *
 * @license MIT
 */
final class SearchByController
{
    use TraitSearchByBody;
    use TraitSearchByController;

    /**
     * Processes the action "SearchBy".
     *
     * @return Response
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Query.
        /** @var SearchByQuery $query */
        $query = $this->queryAdapter->buildQueryFromRequest($this->queryRequest);

        // 2. Business work thanks to the Query.
        $entity = $this->queryHandler->process($query);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess($entity, $query);
        return $this->responseHandler->create($body)->getResponse();
    }
}
