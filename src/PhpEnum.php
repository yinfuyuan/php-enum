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
 * @category PhpEnum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 */

namespace PhpEnum;

use PhpEnum\Exceptions\EnumConflictException;
use PhpEnum\Exceptions\IllegalArgumentException;
use PhpEnum\Exceptions\InstantiationException;
use PhpEnum\Exceptions\MethodNotFoundException;
use PhpEnum\Exceptions\PropertyNotFoundException;

/**
 * This is the complex attribute enumeration types.
 *
 * Note that when using simple enumeration, specialized and efficient {@see Enum} implementations are available.
 *
 * @category PhpEnum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 * @see      Enum
 */
abstract class PhpEnum extends Enum
{
    /**
     * PhpEnum shortcut. Programmers cannot invoke this shortcut.
     *
     * @param string $name      the name of this enum constant.
     * @param mixed  $arguments dynamic parameters, which have no practical use here.
     *
     * @return mixed
     * @see    PhpEnum::propertyEquals()
     * @see    PhpEnum::get()
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws MethodNotFoundException if the property doesn't exist
     */
    public final function __call($name, $arguments)
    {
        if (strlen($name) > 6 && substr($name, -6) === 'Equals') {
            return $this->propertyEquals(substr($name, 0, -6), reset($arguments));
        }

        if (strlen($name) > 3 && strpos($name, 'get') === 0) {
            return $this->get(substr($name, 3));
        }

        throw new MethodNotFoundException('Method ' . static::class . '::' . $name . '() not found');
    }

    /**
     * PhpEnum shortcut. Programmers cannot invoke this shortcut.
     *
     * @param string $name      the name of the method being called.
     * @param array  $arguments an array containing the parameters passed to the $name'ed method.
     *
     * @return mixed
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws EnumConflictException if there are multiple enumerations of the same value
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     * @see    PhpEnum::containsProperty()
     * @see    PhpEnum::ofProperty()
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
     * Get the property value.
     *
     * @param string $property the property name of this enum.
     *
     * @return mixed the property value if the specified property or property getter is exists
     * @throws PropertyNotFoundException if the property or property getter doesn't exist
     */
    public final function get($property)
    {
        $property = lcfirst($property);

        $properties = get_object_vars($this);
        if (array_key_exists($property, $properties)) {
            return $this->{$property};
        }

        $getter = 'get' . ucfirst($property);
        if (in_array($getter, get_class_methods($this))) {
            return $this->{$getter}();
        }

        throw new PropertyNotFoundException('Property ' . static::class . '->' . $property . ' not found');
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
     * Returns true if the specified value is equal to this property value.
     *
     * @param string $property the property name of this enum.
     * @param mixed  $value    the value to be compared for equality with this property value.
     * @param bool   $strict   the default value is true, and the strict mode is used for compared.
     *
     * @return bool true if the specified value is equal to this property value
     * @throws PropertyNotFoundException if the property doesn't exist
     */
    public final function propertyEquals($property, $value, $strict = true)
    {
        $mixed = $this->get($property);
        if (!is_float($mixed)) {
            return $strict ? $mixed === $value : $mixed == $value;
        }
        if ($strict && !is_float($value)) {
            return false;
        }
        $scale = intval($this->scale());
        if ($scale > 0 || !extension_loaded('bcmath')) {
            return strval($mixed) === strval($value);
        }
        return bccomp(strval($mixed), strval($value), $scale) === 0;
    }

    /**
     * Returns false if the specified name does not exists.
     *
     * @param string $name   the name used to check if it exists.
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return bool true if the specified name is exists
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function containsEnumName($name, $prefix = '')
    {
        $values = self::values($prefix);

        return array_key_exists($name, $values);
    }

    /**
     * Returns 0 if the specified value does not exists with this property.
     *
     * @param string $property the property name of this enum.
     * @param mixed  $value    the value used to check if it exists with this property.
     * @param string $prefix   returns the part of that enum name is start with the specified prefix.
     *
     * @return int the count of the property value if the specified property value is exists
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function containsProperty($property, $value, $prefix = '')
    {
        $result = 0;

        $enums = self::values($prefix);

        foreach ($enums as $enum) {
            if ($enum->propertyEquals($property, $value)) {
                $result++;
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
     * @return static|null the enum if the the property with the specified value is exists
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws EnumConflictException if there are multiple enumerations of the same value
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function ofProperty($property, $value, $prefix = '')
    {
        $result = null;

        $enums = self::values($prefix);

        foreach ($enums as $enum) {
            if (!$enum->propertyEquals($property, $value)) {
                continue;
            }
            if (!is_null($result)) {
                throw new EnumConflictException('There are multiple enumerations of the same value');
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
     * @return array the values of all the property of enum
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function properties($property, $prefix = '')
    {
        $properties = [];

        $values = self::values($prefix);

        foreach ($values as $enum) {
            $properties[$enum->name()] = $enum->get($property);
        }

        return $properties;
    }

    /**
     * Returns all the enum names.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return string[] all the enum names
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function names($prefix = '')
    {
        $values = self::values($prefix);

        return array_keys($values);
    }

    /**
     * Returns scale is used to set the number of digits after the decimal place which will be used in the comparison.
     *
     * Due to the special nature of PHP, it is not accurate to directly compare two floating-point types,
     * so when bcmath extension is enabled and scale is set, the bccomp function is preferred for comparison.
     *
     * @link   https://www.php.net/manual/en/language.types.float.php
     * @see    bcmath()
     * @return int
     */
    protected function scale()
    {
        return 0;
    }

    /**
     * Returns enums count.
     *
     * @param string $prefix returns the part of that name is start with the specified prefix.
     *
     * @return int enums count
     * @throws IllegalArgumentException if the constant value is not an array
     * @throws InstantiationException if the enum type missing protected constructor or arguments mismatches
     */
    public static final function count($prefix = '')
    {
        $values = self::values($prefix);

        return count($values);
    }
}
