<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchOneCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Command\TraitPatchOneController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareCommandBody\TraitPatchBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PatchOneController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @license MIT
 */
final class PatchOneController
{
    use TraitPatchBody;
    use TraitPatchOneController;

    /**
     * Processes the action "PatchOne".
     *
     * @return Response
     * @example
     * <code>
     * {
     *     "entityId":"a299fc78-6548-45a3-9823-898c07f76c9b",
     *     "lastName":"Dupont"
     * }
     * </code>
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Command.
        /** @var PatchOneCommand $command */
        $command = $this->commandAdapter->buildCommandFromRequest($this->commandRequest);

        // 2. Business work thanks to the Command.
        $entity = $this->commandHandler->process($command);

        // 3. Format using the business work and return the Response.
        $message = \sprintf('The actor with id %s has been patched.', $command->getEntityId());
        $body = $this->prepareSuccess([$entity], $message);
        return $this->responseHandler->create($body)->getResponse();
    }
}
