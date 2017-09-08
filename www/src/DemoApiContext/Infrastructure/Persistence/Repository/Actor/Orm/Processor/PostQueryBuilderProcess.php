<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Persistence\Repository\Actor\Orm\Processor;

use Doctrine\ORM\QueryBuilder;
use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Processor\ProcessInterface;

/**
 * Class PostQueryBuilderProcess
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor\Orm\Processor
 *
 * @license MIT
 */
class PostQueryBuilderProcess implements ProcessInterface
{
    /**
     * Executes specific treatments after the query was built.
     *
     * @param QueryBuilder $qb
     */
    public function update($qb): void
    {
        // Add something on the queryBuilder!
    }
}
