<?php
declare(strict_types = 1);

namespace DemoApiContext\Presentation\Adapter\Actor\Query;

use DemoApiContext\Application\Cqrs\Actor\Query\SearchByQuery;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\AbstractSearchByQueryAdapter;
use ProjetNormandie\DddProviderBundle\Layer\Presentation\Adapter\Generalisation\QueryAdapterInterface;

/**
 * Class SearchByQueryAdapter
 *
 * @category DemoApiContext
 * @package Presentation
 * @subpackage Adapter\Actor\Query
 *
 * @license MIT
 */
class SearchByQueryAdapter extends AbstractSearchByQueryAdapter implements QueryAdapterInterface
{
    /**
     * @var string $queryNamespace Full namespace of SearchByQuery.
     */
    protected $queryNamespace = SearchByQuery::class;
}
