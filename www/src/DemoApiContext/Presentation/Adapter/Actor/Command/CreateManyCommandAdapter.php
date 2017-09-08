<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\{CreateOneCommand, CreateManyCommand};
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\CommandAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\CommandRequestInterface;

/**
 * Class CreateManyCommandAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @license MIT
 */
class CreateManyCommandAdapter implements CommandAdapterInterface
{
    /**
     * Builds the command "CreateMany" thanks to the request.
     *
     * @param CommandRequestInterface $request
     * @return CommandInterface
     */
    public function buildCommandFromRequest(CommandRequestInterface $request): CommandInterface
    {
        $commands = \array_map([$this, 'buildCommandFromParameters'], $request->getRequestParameters());
        return new CreateManyCommand($commands);
    }

    /**
     * Builds the command "CreateOne" thanks to the parameters of the request.
     *
     * @param array $parameters
     * @return CreateOneCommand
     */
    private function buildCommandFromParameters(array $parameters): CreateOneCommand
    {
        return new CreateOneCommand(
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
