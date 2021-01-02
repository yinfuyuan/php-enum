<?php

namespace PhpEnum\Tests;

/**
 * @method static self ZERO
 * @method static self ONE
 *
 * @method integer getInteger()
 * @method float getFloat()
 * @method string getString()
 * @method array getArray()
 * @method boolean getBoolean()
 * @method null getNull()
 *
 * @method boolean integerEquals($value)
 * @method boolean floatEquals($value)
 * @method boolean stringEquals($value)
 * @method boolean arrayEquals($value)
 * @method boolean booleanEquals($value)
 * @method boolean nullEquals($value)
 *
 * @method static boolean containsInteger($value)
 * @method static boolean containsFloat($value)
 * @method static boolean containsString($value)
 * @method static boolean containsArray($value)
 * @method static boolean containsBoolean($value)
 * @method static boolean containsNull($value)
 *
 * @method static self|null ofInteger($value)
 * @method static self|null ofFloat($value)
 * @method static self|null ofString($value)
 * @method static self|null ofArray($value)
 * @method static self|null ofBoolean($value)
 * @method static self|null ofNull($value, $prefix = '')
 */
class PhpEnum extends \PhpEnum\PhpEnum
{
    const ZERO = [0, 0.0, '', [], FALSE, NULL];
    const ONE = [4+6-8, 2.45+4.234-6.4177, 'This is a very long text.', ['This' => ['is' => 'a', ['array']]], TRUE, NULL];

    protected $integer;
    protected $float;
    protected $string;
    protected $array;
    protected $boolean;
    protected $null;

    protected function construct($integer, $float, $string, $array, $boolean, $null)
    {
        $this->integer = $integer;
        $this->float = $float;
        $this->string = $string;
        $this->array = $array;
        $this->boolean = $boolean;
        $this->null = $null;
    }

    protected function scale()
    {
        return 5;
    }
}
