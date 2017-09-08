<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetOneQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\AbstractGetOneQueryAdapter;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\QueryAdapterInterface;

/**
 * Class GetOneQueryAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @license MIT
 */
class GetOneQueryAdapter extends AbstractGetOneQueryAdapter implements QueryAdapterInterface
{
    /**
     * @var string $queryNamespace Full namespace of GetOneQuery.
     */
    protected $queryNamespace = GetOneQuery::class;
}
