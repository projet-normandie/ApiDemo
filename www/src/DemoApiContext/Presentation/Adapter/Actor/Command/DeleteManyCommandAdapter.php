<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\{DeleteManyCommand, DeleteOneCommand};
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\CommandAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\CommandRequestInterface;

/**
 * Class DeleteManyCommandAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @license MIT
 */
class DeleteManyCommandAdapter implements CommandAdapterInterface
{
    /**
     * Builds the command "DeleteMany" thanks to the request.
     *
     * @param CommandRequestInterface $request
     * @return CommandInterface
     */
    public function buildCommandFromRequest(CommandRequestInterface $request): CommandInterface
    {
        $commands = \array_map([$this, 'buildCommandFromParameters'], $request->getRequestParameters());
        return new DeleteManyCommand($commands);
    }

    /**
     * Builds the command "DeleteOne" thanks to the parameters of the request.
     *
     * @param array $parameters
     * @return DeleteOneCommand
     */
    private function buildCommandFromParameters(array $parameters): DeleteOneCommand
    {
        return new DeleteOneCommand($parameters['entityId'], $parameters['revision']);
    }
}
