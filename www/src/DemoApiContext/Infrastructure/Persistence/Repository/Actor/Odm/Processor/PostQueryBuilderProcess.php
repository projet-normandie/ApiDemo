<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Persistence\Repository\Actor\Odm\Processor;

use Doctrine\ODM\MongoDB\Query\Builder;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Processor\ProcessInterface;

/**
 * Class PostQueryBuilderProcess
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor\Odm\Processor
 *
 * @license MIT
 */
class PostQueryBuilderProcess implements ProcessInterface
{
    /**
     * Executes specific treatments after the query was built.
     *
     * @param Builder $qb
     */
    public function update($qb): void
    {
        // Add something on the queryBuilder!
    }
}
