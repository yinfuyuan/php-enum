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
     * Constant representing enum attribute length.
     *
     * @var integer
     */
    protected static $ENUM_LENGTH = 2;

    /**
     * The enum key.
     *
     * @var mixed $key
     */
    protected $enum_key;

    /**
     * The enum value.
     *
     * @var mixed $value
     */
    protected $enum_value;

    /**
     * Get the enum key.
     *
     * @return mixed
     */
    public function getEnumKey()
    {
        return parent::getKey();
    }

    /**
     * Get the enum value.
     *
     * @return mixed
     */
    public function getEnumValue()
    {
        return parent::getValue();
    }

    /**
     * Get the enum key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->enum_key;
    }

    /**
     * Get the enum value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->enum_value;
    }

    /**
     * Get the array enum all values.
     *
     * @param string $prefix
     * @return array
     */
    public static function getValues($prefix = '')
    {

        $values = [];

        $reflectionClass = new \ReflectionClass(static::class);

        $constants = $reflectionClass->getConstants();

        foreach ($constants as $key => $value) {
            if(empty($prefix) || strstr($key, strtoupper($prefix))) {
                $values[reset($value)] = end($value);
            }
        }

        return $values;

    }

}
