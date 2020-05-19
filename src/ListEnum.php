<?php

namespace PhpEnum;

/**
 * Class ListEnum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 * @license https://opensource.org/licenses/GPL-3.0
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
    protected static $ENUM_LENGTH = 1;

    /**
     * The attribute key index.
     *
     * @var integer $index
     */
    private $index;

    /**
     * The attribute.
     *
     * @var array $attribute
     */
    private $attribute;

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
        $this->attribute = array_values($attribute);
        $this->setIndex(0);
        $reflectionClass = new \ReflectionClass(static::class);
        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED);
        $value = reset($this->attribute);
        foreach ($properties as $property) {
            if(strstr($property->getName(), 'enum_') && null != $value) {
                $property->setAccessible(true);
                $property->setValue($this, $value);
                $value = next($this->attribute);
            }
        }
    }

    /**
     * Dynamically access attribute.
     *
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $letters = str_split('ABCDEFGHIJKLMNOPQRSTTUVWXYZ');
        if(in_array($name, $letters)) {
            return $this->getValue(array_search($name, $letters));
        }
        $index = [];
        if(!preg_match('/\d+/',$name,$index)){
            return null;
        }
        return $this->getValue(reset($index));
    }

    /**
     * Set index value.
     *
     * @param int $index
     * @return $this
     */
    public function setIndex($index)
    {
        if($index >= $this->getLength()) {
            throw new \InvalidArgumentException('Index value does not adhere to a defined valid length');
        }
        $this->index = $index;
        return $this;
    }

    /**
     * Get index value.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Get current attribute value.
     *
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->attribute[$this->index];
    }

    /**
     * Get attribute value by index.
     *
     * @param int $index
     * @return mixed
     */
    public function getValue($index)
    {
        return $this->setIndex($index)->getCurrent();
    }

}
