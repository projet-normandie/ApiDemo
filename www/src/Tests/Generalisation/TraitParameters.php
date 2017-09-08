<?php
declare(strict_types = 1);

namespace Tests\Generalisation;

use InvalidArgumentException;

/**
 * Trait TraitParameters
 *
 * @category Tests
 * @package Generalisation
 *
 * @license MIT
 */
trait TraitParameters
{
    /**
     * @var array Parameters sent
     */
    protected $params = [];

    /**
     * @var array Default parameters
     */
    protected $default = [];

    /**
     * Sets a parameter value using it's name.
     *
     * @param string $name
     * @param $value
     * @return $this
     */
    public function setParam(string $name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Gets the default value of a parameter.
     *
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getDefaultParam(string $name)
    {
        if (!isset($this->default[$name])) {
            throw new InvalidArgumentException('Default parameter "' . $name . '" does not exist.');
        }
        return $this->default[$name];
    }

    /**
     * Builds the query string using the parameters.
     *
     * @return string
     */
    public function getQueryString(): string
    {
        // Do not create a query string if there is no parameters.
        if (empty($this->params)) {
            return '';
        }

        return '/' . \implode('/', \array_merge($this->default, $this->params));
    }
}
