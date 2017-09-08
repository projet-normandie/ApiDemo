<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\{UpdateOneCommand, UpdateManyCommand};
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\CommandAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\CommandRequestInterface;

/**
 * Class UpdateManyCommandAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @license MIT
 */
class UpdateManyCommandAdapter implements CommandAdapterInterface
{
    /**
     * Builds the command "UpdateMany" thanks to the request.
     *
     * @param CommandRequestInterface $request
     * @return CommandInterface
     */
    public function buildCommandFromRequest(CommandRequestInterface $request): CommandInterface
    {
        $commands = \array_map([$this, 'buildCommandFromParameters'], $request->getRequestParameters());
        return new UpdateManyCommand($commands);
    }

    /**
     * Builds the command "UpdateOne" thanks to the parameters of the request.
     *
     * @param array $parameters
     * @return UpdateOneCommand
     */
    private function buildCommandFromParameters(array $parameters): UpdateOneCommand
    {
        return new UpdateOneCommand(
            $parameters['entityId'],
            $parameters['lastName'],
            $parameters['firstName'],
            $parameters['sex'],
            $parameters['birthday'],
            $parameters['email'],
            $parameters['phoneNumber1'],
            $parameters['phoneNumber2'],
            $parameters['salary'],
            $parameters['salaryCurrency']
        );
    }
}
