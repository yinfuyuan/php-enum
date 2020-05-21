<?php

namespace PhpEnum;

/**
 * Class Enum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 */
abstract class Enum
{

    /**
     * Constant representing enum attribute name.
     *
     * @var string $ENUM_KEY
     */
    private static $ENUM_KEY;

    /**
     * Constant representing enum attribute value.
     *
     * @var mixed $ENUM_VALUE
     */
    private static $ENUM_VALUE;

    /**
     * Create a new enum instance.
     *
     * @param mixed $attribute
     * @return void
     */
    protected function __construct($attribute) {}

    /**
     * Dynamically handle calls to the class.
     *
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     *
     * @throws \ErrorException
     */
    public static function __callStatic($name, $arguments)
    {
        $value = constant('static::' . $name);
        self::$ENUM_KEY = $name;
        self::$ENUM_VALUE = $value;
        return new static($value);
    }

    /**
     * Get the enum key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return self::$ENUM_KEY;
    }

    /**
     * Get the enum value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return self::$ENUM_VALUE;
    }

    /**
     * Compare the keys to be equal.
     *
     * @param mixed $key
     * @return bool
     */
    public function keyEquals($key)
    {
        return $this->getKey() == $key;
    }

    /**
     * Compare the values to be equal.
     *
     * @param mixed $value
     * @return bool
     */
    public function valueEquals($value)
    {
        return $this->getValue() == $value;
    }

    /**
     * Get all enum attribute keys.
     *
     * @param string $prefix
     * @return array
     */
    public static function getKeys($prefix = '')
    {

        $values = static::getValues($prefix);

        if(empty($values)) {
            return [];
        }

        return array_keys($values);

    }

    /**
     * Get all enum values.
     *
     * @param string $prefix
     * @return array
     */
    public static function getValues($prefix = '')
    {

        $reflectionClass = new \ReflectionClass(static::class);

        $constants = $reflectionClass->getConstants();

        if(!empty($prefix) && !empty($constants)) {
            foreach ($constants as $key => $value) {
                if(!strstr(strtoupper($key), strtoupper($prefix))) {
                    unset($constants[$key]);
                }
            }
        }

        if(empty($constants)) {
            return [];
        }

        return $constants;

    }

    /**
     * Determine if the key exists.
     *
     * @param mixed $key
     * @param string $prefix
     * @return bool
     */
    public static function keyExist($key, $prefix = '')
    {

        $values = static::getValues($prefix);

        if(empty($values[$key])) {
            return false;
        }

        return true;

    }

    /**
     * Determine if the value exists.
     *
     * @param mixed $value
     * @param string $prefix
     * @return bool
     */
    public static function valueExist($value, $prefix = '')
    {

        $values = static::getValues($prefix);

        $key = array_search($value, $values);

        if(false === $key) {
            return false;
        }

        return true;

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

        $values = static::getValues($prefix);

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

        $values = static::getValues($prefix);

        if(empty($values[$key])) {
            return null;
        }

        return $values[$key];

    }

    /**
     * Get enum size.
     *
     * @param string $prefix
     * @return int
     */
    public static function getSize($prefix = '')
    {

        $values = static::getValues($prefix);

        return count($values);

    }

}
