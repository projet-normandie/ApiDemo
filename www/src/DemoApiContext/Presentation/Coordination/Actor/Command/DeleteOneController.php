<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteOneCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Command\TraitDeleteOneController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareCommandBody\TraitDeleteBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteOneController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @license MIT
 */
final class DeleteOneController
{
    use TraitDeleteBody;
    use TraitDeleteOneController;

    /**
     * Processes the action "DeleteOne".
     *
     * @return Response
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Command.
        /** @var DeleteOneCommand $command */
        $command = $this->commandAdapter->buildCommandFromRequest($this->commandRequest);

        // 2. Business work thanks to the Command.
        $this->commandHandler->process($command);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess('The actor has been deleted.');
        return $this->responseHandler->create($body)->getResponse();
    }
}
