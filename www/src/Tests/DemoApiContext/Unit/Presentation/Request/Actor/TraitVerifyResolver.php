<?php
declare(strict_types = 1);

namespace Tests\DemoApiContext\Unit\Presentation\Request\Actor;

use Phake;

/**
 * Trait TraitVerifyResolver
 *
 * @category Tests\DemoApiContext\Unit
 * @package Presentation
 * @subpackage Request\Actor
 *
 * @license MIT
 */
trait TraitVerifyResolver
{
    /**
     * Verifies the methods called by the resolver of the request.
     *
     * @param int $time
     */
    protected function verifyResolveCalls($time = 1): void
    {
        Phake::verify($this->resolver, Phake::times($time))->resolve(Phake::anyParameters());
    }

    /**
     * Verifies the setDefaults called by the resolver of the request, one for each elements of the request.
     *
     * @param int $time
     */
    protected function verifySetDefaultsCalls($time = 1): void
    {
        Phake::verify($this->resolver, Phake::times($time))->setDefaults(Phake::anyParameters());
    }

    /**
     * Verifies the setRequired called by the resolver of the request, one for each elements of the request.
     *
     * @param int $time
     */
    protected function verifySetRequiredCalls($time = 1): void
    {
        Phake::verify($this->resolver, Phake::times($time))->setRequired(Phake::anyParameters());
    }

    /**
     * Verifies the allowed types called by the resolver of the request, one for each elements of the request.
     *
     * @param int $time
     */
    protected function verifySetAllowedTypesCalls($time = 1): void
    {
        Phake::verify($this->resolver, Phake::times($time))->setAllowedTypes(Phake::anyParameters());
    }
}
