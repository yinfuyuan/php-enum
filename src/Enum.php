<?php

namespace PhpEnum;

/**
 * Class Enum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 * @license https://opensource.org/licenses/GPL-3.0
 */
abstract class Enum
{

    /**
     * Constant representing enum attribute length.
     *
     * @var integer
     */
    protected static $ENUM_LENGTH = 0;

    /**
     * Create a new enum instance.
     *
     * @param array $attributes
     * @return void
     *
     * @throws \InvalidArgumentException
     * @throws \LengthException
     */
    public function __construct($attributes)
    {
        if(!is_array($attributes)) {
            throw new \InvalidArgumentException('Enum attribute only accepts array.');
        }
        if($this->getLength() <= self::$ENUM_LENGTH) {
            throw new \LengthException('Enum attribute length must be greater than zero');
        }
        if($this->getLength() != count($attributes)) {
            throw new \LengthException('Enum attribute length does not adhere to a defined valid length');
        }
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return new static(constant('static::' . $name));
    }

    /**
     * Get enum attribute length.
     *
     * @return int
     */
    public function getLength()
    {
        return static::$ENUM_LENGTH;
    }

}
