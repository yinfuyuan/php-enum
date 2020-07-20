<?php

namespace PhpEnum\Tests;

/**
 * @method static self EMPTY
 * @method static self ONE
 * @method static self TWO
 */
class ListEnum extends \PhpEnum\ListEnum
{

    const EMPTY = [0, 0.0, -0, '', [], FALSE, NULL];
    const ONE = [1, 1.0, -1, '1', [1], TRUE, NULL];
    const TWO = [2, 2.0, -2, '2', [2], TRUE, NULL];

    private $integer;
    private $float;
    private $number;
    private $string;
    private $array;
    private $boolean;
    private $null;

    /**
     * @inheritDoc
     */
    protected final function ListEnum($list)
    {
        list($this->integer, $this->float, $this->number, $this->string,
            $this->array, $this->boolean, $this->null) = $list;
    }

    /**
     * @inheritDoc
     */
    public final static function length()
    {
        return 7;
    }

    public final function getInteger()
    {
        return $this->integer;
    }

    public final function getFloat()
    {
        return $this->float;
    }

    public final function getNumber()
    {
        return $this->number;
    }

    public final function getString()
    {
        return $this->string;
    }

    public final function getArray()
    {
        return $this->array;
    }

    public final function getBoolean()
    {
        return $this->boolean;
    }

    public final function getNull()
    {
        return $this->null;
    }

}
