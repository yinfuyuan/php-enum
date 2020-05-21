<?php

namespace PhpEnum;

/**
 * Class ListEnum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 *
 * @property mixed A
 * @property mixed B
 * @property mixed C
 * @property mixed D
 * @property mixed E
 * @property mixed F
 * @property mixed G
 * @property mixed H
 * @property mixed I
 * @property mixed J
 * @property mixed K
 * @property mixed L
 * @property mixed M
 * @property mixed N
 * @property mixed O
 * @property mixed P
 * @property mixed Q
 * @property mixed R
 * @property mixed S
 * @property mixed T
 * @property mixed U
 * @property mixed V
 * @property mixed W
 * @property mixed X
 * @property mixed Y
 * @property mixed Z
 */
abstract class ListEnum extends Enum
{

    /**
     * Constant representing enum attribute length.
     *
     * @var integer
     */
    protected static $ENUM_LENGTH = 0;

    /**
     * Create a new list enum instance.
     *
     * @param array $attribute
     * @return void
     *
     * @throws \InvalidArgumentException
     * @throws \LengthException
     */
    public function __construct($attribute)
    {
        parent::__construct($attribute);
        if(!is_array($attribute)) {
            throw new \InvalidArgumentException('Enum attribute only accepts array.');
        }
        if(empty(self::getLength())) {
            throw new \LengthException('Enum attribute length must be greater than zero');
        }
        if(self::getLength() != count($attribute)) {
            throw new \LengthException('Enum attribute length does not adhere to a defined valid length');
        }
        $reflectionClass = new \ReflectionClass(static::class);
        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED);
        $value = reset($attribute);
        foreach ($properties as $property) {
            if(!$property->isStatic() && strstr($property->getName(), 'enum_') && null != $value) {
                $property->setAccessible(true);
                $property->setValue($this, $value);
                $value = next($attribute);
            }
        }
    }

    /**
     * Dynamically access attribute.
     *
     * @param string $name
     * @return mixed|null
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function __get($name)
    {
        $letters = str_split('ABCDEFGHIJKLMNOPQRSTTUVWXYZ');
        if(in_array($name, $letters)) {
            return $this->get(array_search($name, $letters));
        }
        $index = [];
        if(!preg_match('/\d+/',$name,$index)){
            throw new \InvalidArgumentException('Undefined enum property');
        }
        return $this->get(intval(reset($index)));
    }

    /**
     * Get the enum using the index.
     *
     * @param integer $index
     * @return mixed
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfRangeException
     */
    public function get($index)
    {

        if(!is_int($index)) {
            throw new \InvalidArgumentException('Enum index only accepts integer');
        }

        if($index < 0 || $index >= self::getLength()) {
            throw new \OutOfRangeException("Enum index out of defined range");
        }

        $value = array_values(parent::getValue());

        return $value[$index];

    }

    /**
     * Get enum attribute length.
     *
     * @return int
     */
    public static function getLength()
    {
        return static::$ENUM_LENGTH;
    }

}
