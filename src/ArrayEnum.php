<?php

namespace PhpEnum;

/**
 * Class ArrayEnum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 * @license https://opensource.org/licenses/GPL-3.0
 */
abstract class ArrayEnum extends Enum
{

    /**
     * Constant representing enum attribute length.
     *
     * @var integer
     */
    protected const LENGTH = 2;

    /**
     * The enum key.
     *
     * @var mixed $key
     */
    private $key;

    /**
     * The enum value.
     *
     * @var mixed $value
     */
    private $value;

    /**
     * Create a new array enum instance.
     *
     * @param array $attributes
     * @return void
     *
     * @throws \InvalidArgumentException
     * @throws \LengthException
     */
    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->key = reset($attributes);
        $this->value = end($attributes);
    }

    /**
     * Get the enum key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the enum value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the array enum all keys.
     *
     * @param string $prefix
     * @return array
     */
    public static function getKeys($prefix = '')
    {

        $values = self::getValues($prefix);

        return array_keys($values);

    }

    /**
     * Get the array enum all values.
     *
     * @param string $prefix
     * @return array
     */
    public static function getValues($prefix = '')
    {

        $values = [];

        $reflectionClass = new \ReflectionClass(static::class);

        $constants = $reflectionClass->getConstants();

        foreach ($constants as $key => $value) {
            if($key == 'LENGTH') {
                continue;
            }
            if(empty($prefix) || strstr($key, strtoupper($prefix))) {
                $values[reset($value)] = end($value);
            }
        }

        return $values;

    }

    /**
     * Search the key based on the value.
     *
     * @param mixed $value
     * @param string $prefix
     * @return mixed|null
     */
    public static function searchKey($value, $prefix = '')
    {

        $values = self::getValues($prefix);

        $key = array_search($value, $values);

        if(false === $key) {
            return null;
        }

        return $key;

    }

    /**
     * Search the value based on the key.
     *
     * @param mixed $key
     * @param string $prefix
     * @return mixed|null
     */
    public static function searchValue($key, $prefix = '')
    {

        $values = self::getValues($prefix);

        if(empty($values[$key])) {
            return null;
        }

        return $values[$key];

    }

}
