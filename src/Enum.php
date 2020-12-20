<?php

/**
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS FILE HEADER.
 *
 * This code is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License version 3 only, as
 * published by the Free Software Foundation.
 *
 * This code is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License
 * version 3 for more details (a copy is included in the LICENSE file that
 * accompanied this code).
 *
 * PHP version 5.6
 *
 * @category Enum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 */

namespace PhpEnum;

use BadMethodCallException;
use ErrorException;
use ReflectionClass;

/**
 * This is the common base class of enumeration types.
 *
 * Note that this is a single valued enumeration type, when using an multivalued enumeration type,
 * specialized and efficient {@see ListEnum} and {@see ArrayEnum} implementations are available.
 *
 * @category Enum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 * @see      ListEnum
 * @see      ArrayEnum
 */
abstract class Enum
{
    /**
     * The name of this enum constant, as declared in the enum declaration.
     *
     * @var string
     */
    private $name; // phpcs:ignore

    /**
     * The value of this enum constant, as declared in the enum declaration.
     *
     * @var mixed
     */
    private $value; // phpcs:ignore

    /**
     * The enum's shared instances.
     *
     * @var array
     */
    private static $instances = []; // phpcs:ignore

    /**
     * The enum's shared constants.
     *
     * @var array
     */
    private static $constants = []; // phpcs:ignore

    /**
     * Enum constructor. Programmers cannot invoke this constructor.
     *
     * @param string $name  the name of this enum constant.
     * @param mixed  $value the value of this enum constant.
     *
     * @see Enum::enumConstruct()
     */
    protected final function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;

        $this->enumConstruct();
    }

    /**
     * Enum bootstrap. Programmers cannot invoke this bootstrap.
     * Programmers can get an enumeration instance by triggering this method
     *
     * @param string $name      the name of this enum constant.
     * @param array  $arguments have not used.
     *
     * @return static an instance of enum
     * @throws ErrorException if the enum has no constant with the specified name
     * @see    Enum::callStatic()
     */
    public static final function __callStatic($name, $arguments)
    {
        $class = static::class;

        if (!defined($class . '::' . $name)) {
            return empty($arguments) ? self::callStatic($name, $arguments) : static::callStatic($name, $arguments);
        }

        if (!empty(self::$instances[$class][$name])) {
            return self::$instances[$class][$name];
        }

        return self::$instances[$class][$name] = new static($name, constant('static::' . $name));
    }

    /**
     * Returns the name of this enum constant, as contained in the declaration.
     * This method may be overridden, though it typically isn't necessary or desirable.
     * An enum type should override this method when a more "programmer-friendly" string form exists.
     *
     * @return string the name of this enum constant
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * This guarantees that enums are never cloned, which is necessary to preserve their "singleton" status.
     *
     * @return void
     */
    public final function __clone()
    {
        throw new BadMethodCallException("can't clone enum");
    }

    /**
     * This guarantees that enums are never serialized, which is necessary to preserve their "singleton" status.
     *
     * @return void
     */
    public final function __sleep()
    {
        throw new BadMethodCallException("can't serialize enum");
    }

    /**
     * This guarantees that enums are never deserialized, which is necessary to preserve their "singleton" status.
     *
     * @return void
     */
    public final function __wakeup()
    {
        throw new BadMethodCallException("can't deserialize enum");
    }

    /**
     * Enum classes cannot have destruct methods.
     */
    public final function __destruct()
    {
    }

    /**
     * Enum construct function. Most programmers will have no use for this method.
     * It is designed for use by sophisticated enum-based data structures, such as {@see ListEnum} and {@see ArrayEnum}.
     *
     * @return void
     */
    protected function enumConstruct()
    {
    }

    /**
     * Enum bootstrap function. Most programmers will have no use for this method.
     * It is designed for use by sophisticated enum-based data structures, such as {@see ListEnum} and {@see ArrayEnum}.
     *
     * @param string $name      the name of this enum constant.
     * @param array  $arguments have not used.
     *
     * @return mixed
     * @throws ErrorException if the enum has no constant with the specified name
     */
    protected static function callStatic($name, $arguments)
    {
        throw new ErrorException("Enum constant is not found");
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
     *
     * @return bool true if the specified object is equal to this enum constant
     */
    public final function equals($enum)
    {
        return $this === $enum;
    }

    /**
     * Returns true if the specified name is equal to this enum name.
     *
     * @param string $name the name to be compared for equality with this enum name.
     *
     * @return bool true if the specified name is equal to this enum name
     */
    public final function enumNameEquals($name)
    {
        return $this->name() === $name;
    }

    /**
     * Returns true if the specified value is equal to this enum value.
     *
     * @param mixed $value  the value to be compared for equality with this enum value.
     * @param bool  $strict the default value is true, and the strict mode is used for compared.
     *
     * @return bool true if the specified value is equal to this enum value
     */
    public final function enumValueEquals($value, $strict = true)
    {
        if (is_float($this->value())) {
            return (!$strict || is_float($value)) && (extension_loaded('bcmath')
                    ? bccomp(strval($this->value()), strval($value)) === 0 : strval($this->value()) === strval($value));
        }
        return $strict ? $this->value() === $value : $this->value() == $value;
    }

    /**
     * Returns all the enum instances and uses the name as the key.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return static[] all the enum instances and uses the name as the key
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function enums($prefix = '')
    {
        $enums = [];

        $constants = self::getEnumConstants();

        foreach ($constants as $key => $value) {
            if (empty($prefix) || strpos($key, $prefix) === 0) {
                $enums[$key] = self::__callStatic($key, []);
            }
        }

        return $enums;
    }

    /**
     * Returns all the enum names.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return string[] all the enum names
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function names($prefix = '')
    {
        $enums = self::enums($prefix);

        return array_keys($enums);
    }

    /**
     * Returns all the enum values and uses the name as the key.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return array all the enum values and uses the name as the key
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function values($prefix = '')
    {
        $values = [];

        $enums = self::enums($prefix);

        foreach ($enums as $enum) {
            $values[$enum->name()] = $enum->value();
        }

        return $values;
    }

    /**
     * Returns true if the specified name is exists.
     *
     * @param mixed $name the name used to check if it exists.
     *
     * @return bool true if the specified name is exists
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function containsEnumName($name)
    {
        $enums = self::enums();

        return array_key_exists($name, $enums);
    }

    /**
     * Returns true if the specified value is exists.
     *
     * @param mixed  $value  the value used to check if it exists.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return bool true if the specified value is exists
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function containsEnumValue($value, $prefix = '')
    {
        $result = false;

        $enums = self::enums($prefix);

        foreach ($enums as $enum) {
            if ($enum->enumValueEquals($value)) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Returns the enum with the specified name.
     *
     * @param string $name the name used to get the enum.
     *
     * @return static|null the enum if the specified name is exists
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function ofEnumName($name)
    {
        $enums = self::enums();

        if (!array_key_exists($name, $enums)) {
            return null;
        }

        return $enums[$name];
    }

    /**
     * Returns the enum with the specified value.
     *
     * @param mixed  $value  the value used to get the enum.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return static|null the enum if the specified value is exists
     * @throws ErrorException if there are multiple enumerations of the same value
     */
    public static final function ofEnumValue($value, $prefix = '')
    {
        $result = null;

        $enums = self::enums($prefix);

        foreach ($enums as $enum) {
            if (!$enum->enumValueEquals($value)) {
                continue;
            }
            if (null != $result) {
                throw new ErrorException('There are multiple enumerations of the same value');
            }
            $result = $enum;
        }

        return $result;
    }

    /**
     * Returns enums count.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return int enums count
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function count($prefix = '')
    {
        $enums = self::enums($prefix);

        return count($enums);
    }

    /**
     * Returns the elements of this enum class or empty array if this class does not have an enum constant.
     *
     * @return array an array containing the constants comprising the enum class represented by this class in the order
     *      they're declared, or empty array if this class does not have an enum constant
     */
    protected static final function getEnumConstants()
    {
        $class = static::class;

        if (!empty(self::$constants[$class])) {
            return self::$constants[$class];
        }

        $reflection = new ReflectionClass(static::class);

        $constants = $reflection->getConstants();

        return self::$constants[$class] = $constants;
    }
}
