<?php
declare(strict_types = 1);

namespace DemoApiContext\Application\Specification\Distance;

use ProjetNormandie\DddProviderBundle\Layer\Application\Specification\{AbstractLeafSpecification, SpecificationInterface};
use ProjetNormandie\DddProviderBundle\Layer\Domain\Service\Generalisation\Manager\CriteriaManagerInterface;

/**
 * Class EarthDistanceSpec
 *
 * @category DemoApiContext
 * @package Application
 * @subpackage Specification\Distance
 */
class EarthDistanceSpec extends AbstractLeafSpecification
{
    /** @var string Unique identifier name of the operator. */
    public const IDENTIFIER = 'earth distance';

    /** @var int Exact number of sub-properties expected in the "field" property. */
    protected const EXPECTED_NB_FIELDS = 2;

    /** @var int Exact number of sub-properties expected in the "value" property. */
    protected const EXPECTED_NB_VALUES = 3;

    /**
     * EarthDistanceSpec constructor.
     *
     * @param mixed $field
     * @param mixed $value
     */
    public function __construct($field, $value)
    {
        parent::__construct($field, $value);

        $this->checkFieldTypeOf(['array'])
            ->checkValueTypeOf(['array'])
            ->checkFieldCount()
            ->checkValueCount();

        $this->checkFieldSubProperties()->checkValueSubProperties();
    }

    /**
     * {@inheritdoc}
     */
    public function renderOrm(): string
    {
        ['latitude' => $latOrigin, 'longitude' => $lonOrigin, 'distance' => $distance] = $this->value;
        ['latitude' => $latField, 'longitude' => $lonField] = $this->field;

        // Operation to get the Earth distance between 2 couples of latitudes and longitudes is:
        // Δ = 2 * 6371008 * sin⁻¹( √(sin²((δ-δ')/2) + cos(δ')*cos(δ)*sin²((λ-λ')/2)) )
        // Where:
        // - Δ is the distance between two points (in meters)
        // - δ is the reference latitude and λ the reference longitude, all in radians
        // - δ' is the origin latitude and λ' the origin longitude, all in radians
        $mathOperation = ' 2 * 6371008 * ASIN(SQRT('
            . 'SIN( (RADIANS(' . $latField . ') - RADIANS(' . $latOrigin . ')) / 2) * '
            . 'SIN( (RADIANS(' . $latField . ') - RADIANS(' . $latOrigin . ')) / 2) + '
            . 'COS(RADIANS(' . $latOrigin . ')) * COS(RADIANS(' . $latField . ') * '
            . 'SIN( (RADIANS(' . $lonField . ') - RADIANS(' . $lonOrigin . ')) / 2) * '
            . 'SIN( (RADIANS(' . $lonField . ') - RADIANS(' . $lonOrigin . ')) / 2)'
            . ')) ';

        return '(' . $distance . ' >= ' . $mathOperation . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function renderOdm(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function renderCouchDB(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function manageSpecificationForManager(CriteriaManagerInterface $manager): SpecificationInterface
    {
        return $this->setField(\array_map([$manager->getFieldsDefinition(), 'getField'], $this->getField()));
    }

    /**
     * Ensures each element of field are of the expected types and subProperty names are correct.
     *
     * @return EarthDistanceSpec
     */
    protected function checkFieldSubProperties(): EarthDistanceSpec
    {
        \array_walk($this->field, static function ($subField, $name) {
            // Check that the name of the sub-property is expected then the type of the subField.
            static::checkSubName('field', ['latitude', 'longitude'], $name);
            static::checkSubTypeOf('field', ['string'], $name, $subField);
        });

        return $this;
    }

    /**
     * Ensures each element of value are of the expected types and subProperty names are correct.
     *
     * @return EarthDistanceSpec
     */
    protected function checkValueSubProperties(): EarthDistanceSpec
    {
        \array_walk($this->value, static function ($subValue, $name) {
            // Check that the name of the sub-property is expected then the type of the subValue.
            static::checkSubName('value', ['latitude', 'longitude', 'distance'], $name);
            static::checkSubTypeOf('value', ['integer', 'double'], $name, $subValue);
        });

        return $this;
    }
}
