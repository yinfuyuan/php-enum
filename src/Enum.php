<?php

namespace PhpEnum;

use ErrorException;
use ReflectionClass;

/**
 * This is the common base class of enumeration types.
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 */
abstract class Enum
{

    /**
     * The name of this enum constant, as declared in the enum declaration.
     *
     * @var string
     */
    private $name;

    /**
     * The value of this enum constant, as declared in the enum declaration.
     *
     * @var mixed
     */
    private $value;

    /**
     * The enum's shared instances.
     *
     * @var array
     */
    private static $instances = [];

    /**
     * The enum's shared constants.
     *
     * @var array
     */
    private static $constants = [];

    /**
     * Enum constructor. Programmers cannot invoke this constructor, and should get the instance by magic function.
     *
     * @param string $name the name of this enum constant.
     * @param mixed $value the value of this enum constant.
     */
    protected function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param string $name the name of this enum constant.
     * @param mixed $arguments dynamic parameters, which have no practical use here.
     * @return static an instance of the enum or subclass.
     *
     * @throws ErrorException if the enum has no constant with the specified name or the enum constant is private.
     */
    public final static function __callStatic($name, $arguments)
    {
        $static_class = static::class;

        if(!defined($static_class . '::' . $name)) {
            throw new ErrorException("Enum constant is not found");
        }

        if(!empty(self::$instances[$static_class][$name])) {
            return self::$instances[$static_class][$name];
        }

        return self::$instances[$static_class][$name] = new static($name, constant('static::' . $name));
    }

    /**
     * Returns the name of this enum constant.
     *
     * @return string the name of this enum constant
     */
    public final function name()
    {
        return $this->name;
    }

    /**
     * Returns the value of this enum constant.
     *
     * @return mixed the value of this enum constant
     */
    public final function value()
    {
        return $this->value;
    }

    /**
     * Returns true if the specified object is equal to this enum.
     *
     * @param static $enum the object to be compared for equality with this object.
     * @return bool true if the specified object is equal to this enum constant.
     */
    public final function equals($enum)
    {
        return $this === $enum;
    }

    /**
     * Returns true if the specified name is equal to this enum name.
     *
     * @param string $name the name to be compared for equality with this enum name.
     * @return bool true if the specified name is equal to this enum name.
     */
    public final function nameEquals($name)
    {
        return $this->name() === $name;
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
    public function valueEquals($value, $strict = true)
    {
        return $strict ? $this->value() === $value : $this->value() == $value;
    }

    /**
     * Returns all the enum names.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return string[] all the enum names.
     */
    public final static function names($prefix = '', $match_case = true)
    {
        $values = static::values($prefix, $match_case);

        if(empty($values)) {
            return [];
        }

        return array_keys($values);
    }

    /**
     * Returns all the enum values and uses the name as the key.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return array all the enum values and uses the name as the key.
     */
    public static function values($prefix = '', $match_case = true)
    {
        $constants = self::getConstants();

        if(!empty($prefix) && !empty($constants)) {
            foreach ($constants as $key => $value) {
                if(($match_case && strpos($key, $prefix) === 0) || (!$match_case && stripos($key, $prefix) === 0)) {
                    continue;
                }
                unset($constants[$key]);
            }
        }

        if(empty($constants)) {
            return [];
        }

        return $constants;
    }

    /**
     * Returns all the enum instances and uses the name as the key.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return static[] all the enum instances and uses the name as the key.
     */
    public final static function enums($prefix = '', $match_case = true)
    {
        $enums = [];

        $constants = self::getConstants();

        if(empty($constants)) {
            return $enums;
        }

        $static_class = static::class;

        foreach ($constants as $key => $value) {
            if(!empty($prefix)
                && !(($match_case && strpos($key, $prefix) === 0)
                    || (!$match_case && stripos($key, $prefix) === 0))) {
                continue;
            }
            if(empty(self::$instances[$static_class][$key])) {
                self::$instances[$static_class][$key] = new static($key, constant('static::' . $key));
            }
            $enums[$key] = self::$instances[$static_class][$key];
        }

        return $enums;
    }

    /**
     * Returns true if the specified name is exists.
     *
     * @param mixed $name the name used to check if it exists.
     * @return bool true if the specified name is exists.
     */
    public static function hasName($name)
    {
        $values = static::values();

        return array_key_exists($name, $values);
    }

    /**
     * Returns true if the specified value is exists.
     *
     * @param mixed $value the value used to check if it exists.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return bool true if the specified value is exists.
     */
    public static function hasValue($value, $prefix = '', $match_case = true)
    {
        $values = static::values($prefix, $match_case);

        return (boolean) array_search($value, $values, true);
    }

    /**
     * Returns the enum with the specified name.
     *
     * @param mixed $name the name used to get the enum.
     * @return static|null the enum if the specified name is exists.
     */
    public static function byName($name)
    {
        $enums = static::enums();

        if(!array_key_exists($name, $enums)) {
            return null;
        }

        return $enums[$name];
    }

    /**
     * Returns the enum with the specified value.
     *
     * @param mixed $value the value used to get the enum.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return static|null the enum if the specified value is exists.
     */
    public static function byValue($value, $prefix = '', $match_case = true)
    {
        $values = static::values($prefix, $match_case);

        $name = array_search($value, $values, true);

        if(false === $name) {
            return null;
        }

        return self::byName($name);
    }

    /**
     * Returns enums count.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     * @param bool $match_case the default value is true, match case when comparing name prefix.
     * @return int enums count
     */
    public static function count($prefix = '', $match_case = true)
    {
        $values = static::values($prefix, $match_case);

        return count($values);
    }

    /**
     * Returns the array of constants.
     *
     * @return array the array of constants
     */
    protected final static function getConstants()
    {
        $static_class = static::class;

        if(!empty(self::$constants[$static_class])) {
            return self::$constants[$static_class];
        }

        $reflectionClass = new ReflectionClass(static::class);

        $constants = $reflectionClass->getReflectionConstants();

        foreach ($constants as $constant) {
            if(!$constant->isPrivate()) {
                self::$constants[$static_class][$constant->getName()] = $constant->getValue();
            }
        }

        return self::$constants[$static_class];
    }

}
