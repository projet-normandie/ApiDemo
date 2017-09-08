<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Command;

use DemoApiContext\Application\Cqrs\Actor\Command\DeleteOneCommand;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\AbstractDeleteOneCommandAdapter;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\CommandAdapterInterface;

/**
 * Class DeleteOneCommandAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Command
 *
 * @license MIT
 */
class DeleteOneCommandAdapter extends AbstractDeleteOneCommandAdapter implements CommandAdapterInterface
{
    /**
     * @var string $commandNamespace Full namespace of DeleteOneCommand.
     */
    protected $commandNamespace = DeleteOneCommand::class;
}
