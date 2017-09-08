<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteManyCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Command\TraitDeleteManyController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareCommandBody\TraitDeleteBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteManyController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @license MIT
 */
final class DeleteManyController
{
    use TraitDeleteBody;
    use TraitDeleteManyController;

    /**
     * Processes the action "DeleteMany".
     *
     * @return Response
     * @example
     * <code>
     * [{
     *      "entityId":"0fc55b9c-eda7-4a50-b8df-17941b462327"
     * },{
     *      "entityId":"0845d735-4e9a-4dd0-8b9a-47c78013b17e"
     * },{
     *      "entityId":"73f68c66-97c8-40c3-9520-937c93c54372"
     * }]
     * </code>
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Command.
        /** @var DeleteManyCommand $command */
        $command = $this->commandAdapter->buildCommandFromRequest($this->commandRequest);

        // 2. Business work thanks to the Command.
        $result = $this->commandHandler->process($command);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess(\sprintf('%s row(s) have been deleted.', $result));
        return $this->responseHandler->create($body)->getResponse();
    }
}
