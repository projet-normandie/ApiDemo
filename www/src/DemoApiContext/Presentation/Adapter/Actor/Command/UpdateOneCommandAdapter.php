<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\UpdateOneCommand;
use ProjetNormandie\DddProviderBundle\Layer\Application\Generalisation\Interfaces\CommandInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\CommandAdapterInterface;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Request\Generalisation\Command\CommandRequestInterface;

/**
 * Class UpdateOneCommandAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @license MIT
 */
class UpdateOneCommandAdapter implements CommandAdapterInterface
{
    /**
     * Builds the command "UpdateOne" thanks to the request.
     *
     * @param CommandRequestInterface $request
     * @return CommandInterface
     */
    public function buildCommandFromRequest(CommandRequestInterface $request): CommandInterface
    {
        $parameters = $request->getRequestParameters();

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
