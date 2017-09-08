<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Persistence\Repository\Actor\CouchDB;

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Repository\CouchDB\AbstractDeleteManyRepository;

/**
 * Class DeleteManyRepository
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor\CouchDB
 *
 * @license MIT
 */
class DeleteManyRepository extends AbstractDeleteManyRepository
{
    use TraitInitDesignDocument;
}
