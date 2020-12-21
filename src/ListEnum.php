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
 * @category ListEnum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 */

namespace PhpEnum;

use ErrorException;
use InvalidArgumentException;
use LengthException;
use ReflectionClass;

/**
 * This is the common base class of multivalued enumeration types.
 *
 * Note that when using an single valued enumeration type {@see Enum} are available,
 * and when using an two value enumeration type {@see ArrayEnum} are available.
 *
 * @category ListEnum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 * @see      Enum
 * @see      ArrayEnum
 */
abstract class ListEnum extends Enum
{
    /**
     * The enum's shared properties.
     *
     * @var array
     */
    private static $properties = []; // phpcs:ignore

    /**
     * ListEnum expand function. Programmers cannot invoke this constructor.
     *
     * @param string $name      the name of this enum constant.
     * @param mixed  $arguments dynamic parameters, which have no practical use here.
     *
     * @return mixed
     * @see    ListEnum::propertyEquals()
     * @see    ListEnum::getProperty()
     * @throws ErrorException if the enum has no constant with the specified name or the enum constant is private.
     */
    public final function __call($name, $arguments)
    {
        if (strlen($name) > 6 && substr($name, -6) === 'Equals') {
            return $this->propertyEquals(substr($name, 0, -6), reset($arguments));
        }

        if (strlen($name) > 3 && strpos($name, 'get') === 0) {
            return $this->getProperty(substr($name, 3));
        }

        throw new ErrorException('Call to undefined method');
    }

    /**
     * ListEnum constructor. Programmers cannot invoke this constructor, and should get the instance by magic function.
     *
     * @return void
     * @throws InvalidArgumentException if list enum constant type is not array.
     * @throws LengthException if list enum length does not adhere to defined length.
     */
    protected final function enumConstruct()
    {
        if (!is_array($this->value())) {
            throw new InvalidArgumentException('List enum constant only accepts array');
        }

        $length = static::length();
        if (!is_int($length) || $length <= 0) {
            throw new LengthException('List enum constant length must be greater than zero');
        }

        if ($length != count($this->value())) {
            throw new LengthException('List enum constant length does not adhere to defined length');
        }

        call_user_func_array([$this, 'listEnumConstruct'], $this->value());
    }

    /**
     * ListEnum expand function. Programmers cannot invoke this constructor.
     *
     * @param string $name      the name of the method being called.
     * @param array  $arguments an array containing the parameters passed to the $name'ed method.
     * 
     * @return mixed
     * @see    ListEnum::containsProperty()
     * @see    ListEnum::ofProperty()
     * @throws ErrorException if the enum has no constant with the specified name.
     */
    protected static final function callStatic($name, $arguments)
    {
        $value = reset($arguments);
        $prefix = next($arguments);

        if (strlen($name) > 8 && strpos($name, 'contains') === 0) {
            return self::containsProperty(substr($name, 8), $value, is_string($prefix) ? $prefix : '');
        }

        if (strlen($name) > 2 && strpos($name, 'of') === 0) {
            return self::ofProperty(substr($name, 2), $value, is_string($prefix) ? $prefix : '');
        }

        return parent::callStatic($name, $arguments);
    }

    /**
     * ListEnum construct function. Programmers cannot invoke this constructor,
     * and must override this function to assign values to properties.
     *
     * @example list(mixed $var1 [, mixed $... ]) = $this->value();
     * @return  void
     * @see     ArrayEnum::listEnumConstruct()
     */
    protected abstract function listEnumConstruct();

    /**
     * Get the property value.
     *
     * @param string $property the property name of this enum.
     *
     * @return mixed the property value if the specified property is exists
     * @throws ErrorException if the property doesn't exist
     */
    public final function getProperty($property)
    {
        $properties = $this->getEnumProperties();
        $property = lcfirst($property);

        if (!array_key_exists($property, $properties)) {
            throw new ErrorException('Access to undefined property');
        }

        return $properties[$property];
    }

    /**
     * Returns true if the specified value is equal to this property value.
     *
     * @param string $property the property name of this enum.
     * @param mixed  $value    the value to be compared for equality with this property value.
     * @param bool   $strict   the default value is true, and the strict mode is used for compared.
     *
     * @return bool true if the specified value is equal to this property value
     * @throws ErrorException if the property doesn't exist
     */
    public final function propertyEquals($property, $value, $strict = true)
    {
        $mixed = $this->getProperty($property);

        if (is_float($mixed)) {
            $scale = intval($this->compScale());
            return (!$strict || is_float($value)) && ($scale > 0 && extension_loaded('bcmath')
                    ? bccomp(strval($mixed), strval($value), $scale) === 0
                    : strval($mixed) === strval($value));
        }

        return $strict ? $mixed === $value : $mixed == $value;
    }

    /**
     * Returns true if the specified value is exists with this property.
     *
     * @param string $property the property name of this enum.
     * @param mixed  $value    the value used to check if it exists with this property.
     * @param string $prefix   returns the part of that enum name is start with the specified prefix.
     *
     * @return bool true if the specified value is exists with this property
     * @throws ErrorException if the property doesn't exist
     */
    public static final function containsProperty($property, $value, $prefix = '')
    {
        $result = false;

        $enums = self::enums($prefix);

        foreach ($enums as $enum) {
            if ($enum->propertyEquals($property, $value)) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Returns the enum by the property with the specified value.
     *
     * @param string $property the property name of this enum.
     * @param mixed  $value    the value used to get the enum.
     * @param string $prefix   returns the part of that enum name is start with the specified prefix.
     *
     * @return ListEnum|null the enum if the the property with the specified value is exists
     * @throws ErrorException if the property doesn't exist or there are multiple enumerations of the same value
     */
    public static final function ofProperty($property, $value, $prefix = '')
    {
        $result = null;

        $enums = self::enums($prefix);

        foreach ($enums as $enum) {
            if (!$enum->propertyEquals($property, $value)) {
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
     * Returns the values of all the property of enum and uses the enum name as the key.
     *
     * @param string $property the property name of this enum.
     * @param string $prefix   returns the part of that enum name is start with the specified prefix.
     *
     * @return array the values of all the property of enum and uses the enum name as the key
     * @throws ErrorException if an incorrect enumeration name exists
     */
    public static final function getProperties($property = '', $prefix = '')
    {
        $properties = [];

        $enums = self::enums($prefix);

        foreach ($enums as $enum) {
            $properties[$enum->name()] = empty($property) ? $enum->getEnumProperties() : $enum->getProperty($property);
        }

        return $properties;
    }

    /**
     * Returns list enum constant length.
     * Programmers must override this function to returns a integers greater than zero.
     *
     * @return integer list enum constant length
     */
    public static final function length()
    {
        $constants = self::getEnumConstants();
        if (empty($constants)) {
            return 0;
        }
        $constant = reset($constants);
        if (!is_array($constant)) {
            return 0;
        }
        return count($constant);
    }

    /**
     * Returns the array of properties.
     *
     * @return array the array of properties
     */
    protected final function getEnumProperties()
    {
        $static_class = static::class;

        if (!empty(self::$properties[$static_class][$this->name()])) {
            return self::$properties[$static_class][$this->name()];
        }

        self::$properties[$static_class][$this->name()] = [];

        $reflectionClass = new ReflectionClass(static::class);

        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            if (!$property->isStatic()) {
                $property->setAccessible(true);
                self::$properties[$static_class][$this->name()][$property->getName()] = $property->getValue($this);
            }
        }

        return self::$properties[$static_class][$this->name()];
    }
}
