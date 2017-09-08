<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetAllQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\AbstractGetAllQueryAdapter;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\QueryAdapterInterface;

/**
 * Class GetAllQueryAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @license MIT
 */
class GetAllQueryAdapter extends AbstractGetAllQueryAdapter implements QueryAdapterInterface
{
    /**
     * @var string $queryNamespace Full namespace of GetAllQuery.
     */
    protected $queryNamespace = GetAllQuery::class;
}
