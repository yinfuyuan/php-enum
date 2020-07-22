<?php

namespace PhpEnum;

use ErrorException;
use InvalidArgumentException;
use LengthException;

/**
 * Class ListEnum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 */
abstract class ListEnum extends Enum
{

    /**
     * ListEnum constructor. Programmers cannot invoke this constructor, and should get the instance by magic function.
     *
     * @param string $name the name of this enum constant.
     * @param array $value the value of this enum constant.
     *
     * @throws ErrorException if list enum function not implemented.
     * @throws InvalidArgumentException if list enum constant type is not array.
     * @throws LengthException if list enum length does not adhere to defined length.
     */
    protected function __construct($name, $value)
    {
        if(!is_array($value)) {
            throw new InvalidArgumentException('List enum constant only accepts array');
        }

        $length = static::length();
        if(!is_int($length) || $length <= 0) {
            throw new LengthException('List enum constant length must be greater than zero');
        }

        if($length != count($value)) {
            throw new LengthException('List enum constant length does not adhere to defined length');
        }

        parent::__construct($name, $value);

        $this->ListEnum($value);
    }

    /**
     * ListEnum function. Programmers cannot invoke this constructor,
     * and must override this function to assign values to properties.
     *
     * @param array $list the value of this enum constant, and here it is expected to be used assign variables as list.
     * @example list(mixed $var1 [, mixed $... ]) = $list;
     */
    protected abstract function ListEnum($list);

    /**
     * Returns list enum constant length.
     * Programmers must override this function to returns a integers greater than zero.
     *
     * @return int list enum constant length
     */
    public abstract static function length();

}
