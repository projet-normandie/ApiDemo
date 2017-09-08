<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateOneCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Command\TraitCreateOneController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareCommandBody\TraitCreateBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateOneController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @license MIT
 */
final class CreateOneController
{
    use TraitCreateBody;
    use TraitCreateOneController;

    /**
     * Processes the action "CreateOne".
     *
     * @return Response
     * @example
     * <code>
     * {
     *     "lastName":"Dupont",
     *     "firstName":"Foo",
     *     "sex":"F",
     *     "birthday":"2015-01-01",
     *     "email":"false.address@gmail.com",
     *     "phoneNumber1":"0134342233",
     *     "phoneNumber2":"0612131415",
     *     "salary": 100000.0,
     *     "salaryCurrency":"EUR"
     * }
     * </code>
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Command.
        /** @var CreateOneCommand $command */
        $command = $this->commandAdapter->buildCommandFromRequest($this->commandRequest);

        // 2. Business work thanks to the Command.
        $entity = $this->commandHandler->process($command);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess([$entity], 'The actor has been created.');
        return $this->responseHandler->create($body, Response::HTTP_CREATED)->getResponse();
    }
}
