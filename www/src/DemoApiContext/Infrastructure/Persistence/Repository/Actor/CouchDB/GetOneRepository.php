<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Persistence\Repository\Actor\CouchDB;

use ProjetNormandie\DddProviderBundle\Layer\Infrastructure\Persistence\Repository\CouchDB\AbstractGetOneRepository;

/**
 * Class GetOneRepository
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor\CouchDB
 *
 * @license MIT
 */
class GetOneRepository extends AbstractGetOneRepository
{
    use TraitInitDesignDocument;
}
