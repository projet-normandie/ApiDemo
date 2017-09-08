<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\UpdateOneCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Command\TraitUpdateOneController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareCommandBody\TraitUpdateBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateOneController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @license MIT
 */
final class UpdateOneController
{
    use TraitUpdateBody;
    use TraitUpdateOneController;

    /**
     * Processes the action "UpdateOne".
     *
     * @return Response
     * @example
     * <code>
     * {
     *     "entityId":"a299fc78-6548-45a3-9823-898c07f76c9b",
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
        /** @var UpdateOneCommand $command */
        $command = $this->commandAdapter->buildCommandFromRequest($this->commandRequest);

        // 2. Business work thanks to the Command.
        $entity = $this->commandHandler->process($command);

        // 3. Format using the business work and return the Response.
        $message = \sprintf('The actor with id %s has been updated.', $command->getEntityId());
        $body = $this->prepareSuccess([$entity], $message);
        return $this->responseHandler->create($body)->getResponse();
    }
}
