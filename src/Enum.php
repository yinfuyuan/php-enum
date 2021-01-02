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

use PhpEnum\Exceptions\CloneNotSupportedException;
use PhpEnum\Exceptions\IllegalArgumentException;
use PhpEnum\Exceptions\InstantiationException;
use PhpEnum\Exceptions\InvalidObjectException;
use ReflectionClass;
use ReflectionMethod;

/**
 * This is the common base class of enumeration types.
 *
 * Note that this is a simple enumeration type, when using complex attribute enumeration,
 * specialized and efficient {@see PhpEnum} implementations are available.
 *
 * @category Enum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 * @link     https://docs.oracle.com/javase/tutorial/java/javaOO/enum.html
 * @link     https://docs.oracle.com/javase/8/docs/api/java/lang/Enum.html
 * @see      PhpEnum
 */
abstract class Enum
{
    /**
     * The name of this enum constant, as declared in the enum declaration.
     * Most programmers should use the {@see Enum::__toString()} method rather than accessing this field.
     *
     * @var string
     */
    private $name; // phpcs:ignore

    /**
     * The ordinal of this enumeration constant (its position in the enum declaration,
     * where the initial constant is assigned an ordinal of zero).
     *
     * Most programmers will have no use for this field. It is designed for
     * use by sophisticated enum-based data structures.
     *
     * @var int
     */
    private $ordinal; // phpcs:ignore

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
     * The enum's shared constructors.
     *
     * @var int[]
     */
    private static $constructors = []; // phpcs:ignore

    /**
     * Enum constructor. Programmers cannot invoke this constructor.
     *
     * @param string $name    The name of this enum constant, which is the identifier used to declare it.
     * @param int    $ordinal The ordinal of this enumeration constant (its position in the enum declaration,
     *                        where the initial constant is assigned an ordinal of zero).
     */
    private final function __construct($name, $ordinal)
    {
        $this->name = $name;
        $this->ordinal = $ordinal;
    }

    /**
     * Enum bootstrap. Programmers cannot invoke this bootstrap.
     *
     * @param string $name      the name of this enum constant.
     * @param array  $arguments have not used.
     *
     * @return static the enum if the specified name is exists
     * @throws IllegalArgumentException if the specified enum type has no constant with the specified name,
     *          or the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     * @see    Enum::callStatic()
     */
    public static final function __callStatic($name, $arguments)
    {
        $constants = self::getEnumConstants();
        if (!array_key_exists($name, $constants)) {
            return static::callStatic($name, $arguments);
        }

        $class = static::class;
        if (!empty(self::$instances[$class][$name])) {
            return self::$instances[$class][$name];
        }

        $arguments = $constants[$name];
        if (!is_array($arguments)) {
            throw new IllegalArgumentException('Enum constant only accepts an array');
        }
        if (self::getEnumConstructors() !== count($arguments)) {
            throw new InstantiationException('Enum missing protected constructor or arguments mismatches');
        }

        $ordinal = array_flip(array_keys($constants))[$name];
        self::$instances[$class][$name] = new static($name, $ordinal);
        if (method_exists($class, 'construct')) {
            self::$instances[$class][$name]->construct(...$arguments);
        }

        return self::$instances[$class][$name];
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
     * @throws CloneNotSupportedException
     */
    public final function __clone()
    {
        throw new CloneNotSupportedException();
    }

    /**
     * This guarantees that enums are never serialized, which is necessary to preserve their "singleton" status.
     *
     * @return void
     * @throws InvalidObjectException
     */
    public final function __sleep()
    {
        throw new InvalidObjectException("can't serialize enum");
    }

    /**
     * This guarantees that enums are never deserialized, which is necessary to preserve their "singleton" status.
     *
     * @return void
     * @throws InvalidObjectException
     */
    public final function __wakeup()
    {
        throw new InvalidObjectException("can't deserialize enum");
    }

    /**
     * Enum classes cannot have destruct methods.
     */
    public final function __destruct()
    {
    }

    /**
     * Enum bootstrap function. Most programmers will have no use for this method.
     * It is designed for use by sophisticated enum-based data structures, such as {@see PhpEnum} .
     *
     * @param string $name      the name of this enum constant.
     * @param array  $arguments have not used.
     *
     * @return mixed
     * @throws IllegalArgumentException if the specified enum type has no constant with the specified name,
     *          or the specified class object does not represent an enum type
     */
    protected static function callStatic($name, $arguments)
    {
        throw new IllegalArgumentException('No enum constant ' . static::class . '::' . $name);
    }

    /**
     * Returns the name of this enum constant, exactly as declared in its enum declaration.
     *
     * Most programmers should use the {@see Enum::__toString()} method in preference to this one,
     * as the toString method may return a more user-friendly name.  This method is designed primarily
     * for use in specialized situations where correctness depends on getting the exact name,
     * which will not vary from release to release.
     *
     * @return string the name of this enum constant
     */
    public final function name()
    {
        return $this->name;
    }

    /**
     * Returns the ordinal of this enumeration constant (its position in its enum declaration,
     * where the initial constant is assigned an ordinal of zero).
     *
     * Most programmers will have no use for this method. It is designed for
     * use by sophisticated enum-based data structures.
     *
     * @return mixed the ordinal of this enumeration constant
     */
    public final function ordinal()
    {
        return $this->ordinal;
    }

    /**
     * Returns true if the specified object is equal to this enum constant.
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
     * Returns all the enum instances and uses the name as the key.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return static[] all the enum instances and uses the name as the key
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function values($prefix = '')
    {
        $values = [];

        $constants = self::getEnumConstants();

        foreach ($constants as $key => $value) {
            if (empty($prefix) || strpos($key, $prefix) === 0) {
                $values[$key] = self::__callStatic($key, []);
            }
        }

        return $values;
    }

    /**
     * Returns the enum constant with the specified name. The name must match exactly an identifier
     * used to declare an enum constant. (Extraneous whitespace characters are not permitted.)
     *
     * @param string $name   the name of the constant to return.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return static the enum if the specified name is exists
     * @throws IllegalArgumentException if the specified enum type has no constant with the specified name,
     *          or the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function valueOf($name, $prefix = '')
    {
        $values = self::values($prefix);

        if (!array_key_exists($name, $values)) {
            throw new IllegalArgumentException('No enum constant ' . static::class . '::' . $name);
        }

        return $values[$name];
    }

    /**
     * Returns the elements of this enum class or empty array if this class does not have an enum constant.
     *
     * @return array an array containing the constants comprising the enum class represented by this class in the order
     *          they're declared, or empty array if this class does not have an enum constant
     */
    protected static final function getEnumConstants()
    {
        $class = static::class;

        if (array_key_exists($class, self::$constants)) {
            return self::$constants[$class];
        }

        $reflection = new ReflectionClass(static::class);

        return self::$constants[$class] = $reflection->getConstants();
    }

    /**
     * Returns the number of required parameters for the constructor.
     *
     * @return int the number of required parameters for the constructor
     */
    protected static final function getEnumConstructors()
    {
        $class = static::class;

        if (array_key_exists($class, self::$constructors)) {
            return self::$constructors[$class];
        }
        if (!method_exists($class, 'construct')) {
            return self::$constructors[$class] = 0;
        }

        $reflection = new ReflectionMethod(static::class, 'construct');

        if ($reflection->isProtected()) {
            return self::$constructors[$class] = $reflection->getNumberOfRequiredParameters();
        }

        return self::$constructors[$class] = -1;
    }
}
