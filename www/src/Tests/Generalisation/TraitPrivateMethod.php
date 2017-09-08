<?php
declare(strict_types = 1);

namespace Tests\Generalisation;

use Exception;
use InvalidArgumentException;
use ReflectionMethod;

/**
 * Trait TraitPrivateMethod
 *
 * @category Tests
 * @package Generalisation
 *
 * @license MIT
 */
trait TraitPrivateMethod
{
    /**
     * call private/protected method
     *
     * @param   string    $method private/protected method to call
     * @param   object    $object instance of $class
     * @param   null      $args   must be an array if not null
     * @throws  Exception         if $args is not an array
     * @return  mixed
     * @example
     * <code>
     *   $this->callPrivateMethod(
     *       EntityWFGenerateVOListener::class,
     *       'setSituationVO',
     *       $this->WFListener,
     *       [$this->event]
     *    );
     * </code>
     */
    protected static function callPrivateMethod($method, $object, $args = null)
    {
        $method = new ReflectionMethod($object, $method);
        $method->setAccessible(true);
        if (null === $args) {
            return $method->invoke($object);
        }

        if (!\is_array($args)) {
            throw new InvalidArgumentException('$args param must be an array.');
        }
        return $method->invokeArgs($object, $args);
    }
}
