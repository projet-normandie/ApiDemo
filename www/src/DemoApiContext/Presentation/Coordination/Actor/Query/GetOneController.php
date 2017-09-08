<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetOneQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Query\TraitGetOneController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareQueryBody\TraitGetOneBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetOneController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Query
 *
 * @license MIT
 */
final class GetOneController
{
    use TraitGetOneBody;
    use TraitGetOneController;

    /**
     * Processes the action "GetOne".
     *
     * @return Response
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Query.
        /** @var GetOneQuery $query */
        $query = $this->queryAdapter->buildQueryFromRequest($this->queryRequest);

        // 2. Business work thanks to the Query.
        $entity = $this->queryHandler->process($query);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess($entity);
        return $this->responseHandler->create($body)->getResponse();
    }
}
