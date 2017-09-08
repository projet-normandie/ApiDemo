<?php
declare(strict_types = 1);

namespace Tests\Generalisation;

use ReflectionClass;

/**
 * Trait TraitPrivateProperty
 *
 * @category Tests
 * @package Generalisation
 *
 * @license MIT
 */
trait TraitPrivateProperty
{
    /**
     * Get private/protected property $property from object $object from class $class.
     *
     * @param string $property
     * @param $object
     * @return mixed
     */
    protected static function getPrivateProperty(string $property, $object)
    {
        $reflectionProperty = (new ReflectionClass($object))->getProperty($property);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty->getValue($object);
    }
}
