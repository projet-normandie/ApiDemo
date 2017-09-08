<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Coordination\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\PatchManyCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Coordination\Generalisation\Command\TraitPatchManyController;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Response\Generalisation\PrepareCommandBody\TraitPatchBody;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PatchManyController
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Coordination\Actor\Command
 *
 * @license MIT
 */
final class PatchManyController
{
    use TraitPatchBody;
    use TraitPatchManyController;

    /**
     * Processes the action "PatchMany".
     *
     * @return Response
     * @example
     * <code>
     * [
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
     * },
     * {
     *     "entityId":"34c2877e-a8c8-4fc4-8811-c49810dd48cc",
     *     "lastName":"nicoTest",
     *     "firstName":"testNico",
     *     "sex":"M",
     *     "birthday":"2017-03-17",
     *     "email":"example@example.com",
     *     "phoneNumber1":"0134342233",
     *     "phoneNumber2":"0612131415",
     *     "salary":100000.2,
     *     "salaryCurrency":"EUR"
     * }
     * ]
     * </code>
     */
    public function processAction(): Response
    {
        // 1. Transform Request to Command.
        /** @var PatchManyCommand $command */
        $command = $this->commandAdapter->buildCommandFromRequest($this->commandRequest);

        // 2. Business work thanks to the Command.
        $entities = $this->commandHandler->process($command);

        // 3. Format using the business work and return the Response.
        $body = $this->prepareSuccess($entities, 'Actors have been patched.');
        return $this->responseHandler->create($body)->getResponse();
    }
}
