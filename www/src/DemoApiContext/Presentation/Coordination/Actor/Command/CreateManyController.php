<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\CreateManyCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Command\TraitCreateManyController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareCommandBody\TraitCreateBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateManyController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @license MIT
 */
final class CreateManyController
{
    use TraitCreateBody;
    use TraitCreateManyController;

    /**
     * Processes the action "CreateMany".
     *
     * @return Response
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Command.
        /** @var CreateManyCommand $command */
        $command = $this->commandAdapter->buildCommandFromRequest($this->commandRequest);

        // 2. Business work thanks to the Command.
        $entities = $this->commandHandler->process($command);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess($entities, 'Actors have been created.');
        return $this->responseHandler->create($body, Response::HTTP_CREATED)->getResponse();
    }
}
