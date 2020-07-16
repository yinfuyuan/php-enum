<?php

namespace PhpEnum;

/**
 * Class ArrayEnum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 */
abstract class ArrayEnum extends ListEnum
{

    /**
     * The key of this array enum constant, as declared in the array enum declaration.
     *
     * @var mixed
     */
    private $key;

    /**
     * The value of this array enum constant, as declared in the array enum declaration.
     *
     * @var mixed
     */
    private $value;

    /**
     * @inheritDoc
     */
    protected final function ListEnum($list)
    {
        list($this->key, $this->value) = $list;
    }

    /**
     * @inheritDoc
     */
    public final static function length()
    {
        return 2;
    }

    /**
     * Get the array enum key.
     *
     * @return mixed
     */
    public final function getKey()
    {
        return $this->key;
    }

    /**
     * Get the array enum value.
     *
     * @return mixed
     */
    public final function getValue()
    {
        return $this->value;
    }

    /**
     * Returns true if the specified key is equal to this enum key.
     *
     * When comparing with floating point numbers, you may get unexpected results.
     * @link https://www.php.net/manual/en/language.types.float.php
     *
     * @param string $key the key to be compared for equality with this enum key.
     * @param bool $strict the default value is true, and the strict mode is used for compared.
     * @return bool true if the specified key is equal to this enum key.
     */
    public final function keyEquals($key, $strict = true)
    {
        return $strict ? $this->getKey() === $key : $this->getKey() == $key;
    }

    /**
     * Returns true if the specified value is equal to this enum value.
     *
     * When comparing with floating point numbers, you may get unexpected results.
     * @link https://www.php.net/manual/en/language.types.float.php
     *
     * @param mixed $value the value to be compared for equality with this enum value.
     * @param bool $strict the default value is true, and the strict mode is used for compared.
     * @return bool true if the specified value is equal to this enum value.
     */
    public final function valueEquals($value, $strict = true)
    {
        return $strict ? $this->getValue() === $value : $this->getValue() == $value;
    }

    /**
     * Returns all the enum keys.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return string[] all the enum keys.
     */
    public final static function getKeys($prefix = '', $match_case = true)
    {
        $values = static::getValues($prefix, $match_case);

        if(empty($values)) {
            return [];
        }

        return array_keys($values);
    }

    /**
     * Returns all the enum values and uses the key as the key.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return array all the enum values and uses the key as the key.
     */
    public static function getValues($prefix = '', $match_case = true)
    {
        $values = [];

        $valueArray = self::values($prefix, $match_case);

        foreach ($valueArray as $value) {
            $values[reset($value)] = end($value);
        }

        return $values;
    }

    /**
     * Returns all the enum instances and uses the key as the key.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return static[] all the enum instances and uses the key as the key.
     */
    public final static function getEnums($prefix = '', $match_case = true)
    {
        $enums = [];

        $enumArray = self::enums($prefix, $match_case);

        foreach ($enumArray as $enum) {
            $enums[$enum->getKey()] = $enum;
        }

        return $enums;
    }

    /**
     * Returns true if the specified key is exists.
     *
     * @param mixed $key the key used to check if it exists.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return bool true if the specified key is exists.
     */
    public final static function hasKey($key, $prefix = '', $match_case = true)
    {
        $values = static::getValues($prefix, $match_case);

        return array_key_exists($key, $values);
    }

    /**
     * Returns true if the specified value is exists.
     *
     * @param mixed $value the value used to check if it exists.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return bool true if the specified value is exists.
     */
    public final static function hasValue($value, $prefix = '', $match_case = true)
    {
        $values = static::getValues($prefix, $match_case);

        return (boolean) array_search($value, $values, true);
    }

    /**
     * Returns the enum with the specified key.
     *
     * @param mixed $key the key used to get the enum.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return static|null the enum if the specified key is exists.
     */
    public final static function byKey($key, $prefix = '', $match_case = true)
    {
        $enums = static::getEnums($prefix, $match_case);

        if(!array_key_exists($key, $enums)) {
            return null;
        }

        return $enums[$key];
    }

    /**
     * Returns the enum with the specified value.
     *
     * @param mixed $value the value used to get the enum.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return static|null the enum if the specified value is exists.
     */
    public final static function byValue($value, $prefix = '', $match_case = true)
    {
        $values = static::getValues($prefix, $match_case);

        $key = array_search($value, $values, true);

        if(false === $key) {
            return null;
        }

        return self::byKey($key, $prefix, $match_case);
    }

}
