<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\GetByIdsQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\AbstractGetByIdsQueryAdapter;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\QueryAdapterInterface;

/**
 * Class GetByIdsQueryAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @license MIT
 */
class GetByIdsQueryAdapter extends AbstractGetByIdsQueryAdapter implements QueryAdapterInterface
{
    /**
     * @var string $queryNamespace Full namespace of GetByIdsQuery.
     */
    protected $queryNamespace = GetByIdsQuery::class;
}
