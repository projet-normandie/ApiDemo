<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetByIdsQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Query\TraitGetByIdsController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareQueryBody\TraitGetByIdsBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetByIdsController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Query
 *
 * @license MIT
 */
final class GetByIdsController
{
    use TraitGetByIdsBody;
    use TraitGetByIdsController;

    /**
     * Processes the action "GetByIds".
     *
     * @return Response
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Query.
        /** @var GetByIdsQuery $query */
        $query = $this->queryAdapter->buildQueryFromRequest($this->queryRequest);

        // 2. Business work thanks to the Query.
        $results = $this->queryHandler->process($query);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess($results);
        return $this->responseHandler->create($body)->getResponse();
    }
}
