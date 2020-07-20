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
     * @return mixed the array enum key.
     */
    public final function getKey()
    {
        return $this->key;
    }

    /**
     * Get the array enum value.
     *
     * @return mixed the array enum value.
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
     * @param mixed $key the key to be compared for equality with this enum key.
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
     * @return array all the enum keys.
     */
    public final static function getKeys($prefix = '', $match_case = true)
    {
        $keys = [];

        $values = self::values($prefix, $match_case);

        foreach ($values as $value) {
            $keys[] = reset($value);
        }

        return $keys;
    }

    /**
     * Returns all the enum values.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return array all the enum values.
     */
    public static function getValues($prefix = '', $match_case = true)
    {
        $values = [];

        $valueArray = self::values($prefix, $match_case);

        foreach ($valueArray as $value) {
            $values[] = end($value);
        }

        return $values;
    }

    /**
     * Returns all the enum instances.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return static[] all the enum instances.
     */
    public final static function getEnums($prefix = '', $match_case = true)
    {
        $enums = self::enums($prefix, $match_case);

        return array_values($enums);
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
        $keys = static::getKeys($prefix, $match_case);

        return array_search($key, $keys, true) !== false;
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

        return array_search($value, $values, true) !== false;
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
        $static = null;

        $enums = static::getEnums($prefix, $match_case);

        foreach ($enums as $enum) {
            if($enum->keyEquals($key)) {
                $static = $enum;
                break;
            }
        }

        return $static;
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
        $static = null;

        $enums = static::getEnums($prefix, $match_case);

        foreach ($enums as $enum) {
            if($enum->valueEquals($value)) {
                $static = $enum;
                break;
            }
        }

        return $static;
    }

}
