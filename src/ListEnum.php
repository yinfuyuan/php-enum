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

use InvalidArgumentException;
use PhpEnum\Exceptions\EnumConflictException;
use PhpEnum\Exceptions\InvalidConstructException;
use PhpEnum\Exceptions\MethodNotFoundException;
use PhpEnum\Exceptions\PropertyNotFoundException;
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
     * List enum construct method name.
     *
     * Programmers must implement this method in subclass. This method cannot be defined as an abstract method
     * or interface because the number of arguments is uncertain.
     *
     * @see ArrayEnum::listEnumConstruct()
     * @var string
     */
    private $construct = 'listEnumConstruct'; // phpcs:ignore

    /**
     * The enum's shared params.
     *
     * @var array
     */
    private static $params = []; // phpcs:ignore

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
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws MethodNotFoundException if the property doesn't exist
     */
    public final function __call($name, $arguments)
    {
        if (strlen($name) > 6 && substr($name, -6) === 'Equals') {
            return $this->propertyEquals(substr($name, 0, -6), reset($arguments));
        }

        if (strlen($name) > 3 && strpos($name, 'get') === 0) {
            return $this->getProperty(substr($name, 3));
        }

        throw new MethodNotFoundException('Method ' . static::class . '::' . $name . '() not found');
    }

    /**
     * ListEnum constructor. Programmers cannot invoke this constructor, and should get the instance by magic function.
     *
     * @return void
     * @throws InvalidArgumentException if list enum constant type is not an correct array
     * @throws InvalidConstructException if List enum are missing construct method or parameter mismatches
     */
    protected final function enumConstruct()
    {
        if (!is_array($this->value()) || count($this->value()) === 0) {
            throw new InvalidArgumentException('List enum constant only accepts an not empty array');
        }
        
        if ($this->getEnumParams() !== count($this->value())) {
            throw new InvalidConstructException(
                'List enum are missing protected function ' . $this->construct . ' or parameter mismatches'
            );
        }

        call_user_func_array([$this, $this->construct], $this->value());
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
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws EnumConflictException if there are multiple enumerations of the same value
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
     * @return mixed the property value if the specified property is exists
     * @throws PropertyNotFoundException if the property doesn't exist
     */
    public final function getProperty($property)
    {
        $properties = $this->getEnumProperties();
        $property = lcfirst($property);

        if (array_key_exists($property, $properties)) {
            return $properties[$property];
        }

        throw new PropertyNotFoundException('Property ' . static::class . '->' . $property . ' not found');
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
        $mixed = $this->getProperty($property);
        if (!is_float($mixed)) {
            return $strict ? $mixed === $value : $mixed == $value;
        }
        if ($strict && !is_float($value)) {
            return false;
        }
        if ($this->scale() === 0 || !extension_loaded('bcmath')) {
            return strval($mixed) === strval($value);
        }
        return bccomp(strval($mixed), strval($value), $this->scale()) === 0;
    }

    /**
     * Returns true if the specified value is exists with this property.
     *
     * @param string $property the property name of this enum.
     * @param mixed  $value    the value used to check if it exists with this property.
     * @param string $prefix   returns the part of that enum name is start with the specified prefix.
     *
     * @return int true if the specified value is exists with this property
     * @throws PropertyNotFoundException if the property doesn't exist
     */
    public static final function containsProperty($property, $value, $prefix = '')
    {
        $result = 0;

        $enums = self::enums($prefix);

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
     * @return ListEnum|null the enum if the the property with the specified value is exists
     * @throws PropertyNotFoundException if the property doesn't exist
     * @throws EnumConflictException if there are multiple enumerations of the same value
     */
    public static final function ofProperty($property, $value, $prefix = '')
    {
        $result = null;

        $enums = self::enums($prefix);

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
     * @return array the values of all the property of enum and uses the enum name as the key
     * @throws PropertyNotFoundException if the property doesn't exist
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
     * Returns the number of list enum construct required parameters.
     * 
     * @return int the number of list enum construct required parameters
     */
    protected final function getEnumParams()
    {
        $class = static::class;

        if (array_key_exists($class, self::$params)) {
            return self::$params[$class];
        }

        $reflection = new ReflectionClass(static::class);

        if (!$reflection->hasMethod($this->construct)) {
            return self::$params[$class] = 0;
        }

        $method = $reflection->getMethod($this->construct);

        if (!$method->isProtected() || $method->getNumberOfParameters() != $method->getNumberOfRequiredParameters()) {
            return self::$params[$class] = 0;
        }

        return self::$params[$class] = $reflection->getMethod($this->construct)->getNumberOfParameters();
    }

    /**
     * Returns the array of properties.
     *
     * @return array the array of properties
     */
    protected final function getEnumProperties()
    {
        $class = static::class;

        if (!empty(self::$properties[$class][$this->name()])) {
            return self::$properties[$class][$this->name()];
        }

        self::$properties[$class][$this->name()] = [];

        $reflection = new ReflectionClass(static::class);

        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            if (!$property->isStatic()) {
                $property->setAccessible(true);
                self::$properties[$class][$this->name()][$property->getName()] = $property->getValue($this);
            }
        }

        return self::$properties[$class][$this->name()];
    }
}
