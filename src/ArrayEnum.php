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

/**
 * This is the array enum class.
 *
 * Note that when using an single valued enumeration type {@see Enum} are available,
 * and when using an multivalued value enumeration type {@see ListEnum} are available.
 *
 * @category Enum
 * @package  PhpEnum
 * @author   yinfuyuan <yinfuyuan@gmail.com>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link     https://github.com/yinfuyuan/php-enum
 * @see      Enum
 * @see      ListEnum
 *
 * @method mixed getKey()
 * @method mixed getValue()
 *
 * @method bool keyEquals(mixed $key)
 * @method bool valueEquals(mixed $value)
 *
 * @method static int containsKey(mixed $value, string $prefix = '')
 * @method static int containsValue(mixed $value, string $prefix = '')
 *
 * @method static self ofKey(mixed $key, string $prefix = '')
 * @method static self ofValue(mixed $value, string $prefix = '')
 */
abstract class ArrayEnum extends ListEnum
{
    /**
     * The key of this array enum constant, as declared in the array enum declaration.
     *
     * @var mixed
     */
    protected $key; // phpcs:ignore

    /**
     * The value of this array enum constant, as declared in the array enum declaration.
     *
     * @var mixed
     */
    protected $value; // phpcs:ignore

    /**
     * ArrayEnum constructor. Programmers cannot invoke this constructor.
     *
     * @param mixed $key   The key of this array enum.
     * @param mixed $value The value of this array enum.
     *
     * @return void
     */
    protected final function listEnumConstruct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
