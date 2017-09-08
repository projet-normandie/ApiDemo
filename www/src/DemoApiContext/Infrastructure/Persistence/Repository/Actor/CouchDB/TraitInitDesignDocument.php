<?php
declare(strict_types = 1);

namespace DemoApiContext\Infrastructure\Persistence\Repository\Actor\CouchDB;

use DemoApiContext\Infrastructure\Persistence\Repository\Actor\CouchDB\Views\DesignDocument;

/**
 * Trait TraitInitDesignDocument
 *
 * @category DemoApiContext
 * @package Infrastructure
 * @subpackage Persistence\Repository\Actor\CouchDB
 *
 * @license MIT
 */
trait TraitInitDesignDocument
{
    /**
     * Initializes the DesignDocument.
     */
    public function initDesignDocument(): void
    {
        $this->designDocument = (new DesignDocument())->initEntityDotNamespace($this->getEntityName());
    }
}
