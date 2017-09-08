<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\{PatchManyCommand, PatchOneCommand};
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\CommandAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\CommandRequestInterface;

/**
 * Class PatchManyCommandAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @license MIT
 */
class PatchManyCommandAdapter implements CommandAdapterInterface
{
    /**
     * Builds the command "PatchMany" thanks to the request.
     *
     * @param CommandRequestInterface $request
     * @return CommandInterface
     */
    public function buildCommandFromRequest(CommandRequestInterface $request): CommandInterface
    {
        $commands = \array_map([$this, 'buildCommandFromParameters'], $request->getRequestParameters());
        return new PatchManyCommand($commands);
    }

    /**
     * Builds the command "PatchOne" thanks to the parameters of the request.
     *
     * @param array $parameters
     * @return PatchOneCommand
     */
    private function buildCommandFromParameters(array $parameters): PatchOneCommand
    {
        return new PatchOneCommand(
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
