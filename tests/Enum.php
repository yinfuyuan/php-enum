<?php

namespace PhpEnum\Tests;

/**
 * @method static self BOOLEAN_TRUE
 * @method static self BOOLEAN_FALSE
 *
 * @method static self INTEGER_ONE
 * @method static self INTEGER_TWO
 * @method static self INTEGER_THREE
 *
 * @method static self NUMBER_ONE
 * @method static self NUMBER_TWO
 *
 * @method static self FLOAT_ONE
 * @method static self FLOAT_TWO
 *
 * @method static self STRING_ONE
 * @method static self STRING_TWO
 *
 * @method static self ARRAY_ONE
 * @method static self ARRAY_TWO
 *
 * @method static self NULL_NULL
 */
class Enum extends \PhpEnum\Enum
{

    const BOOLEAN_TRUE = TRUE;
    const BOOLEAN_FALSE = FALSE;

    public const INTEGER_ONE = 1;
    public const INTEGER_TWO = 2;
    protected const INTEGER_THREE = 3;
    private const INTEGER_FOUR = 4;

    const NUMBER_ONE = 1;
    const NUMBER_TWO = 2;

    const FLOAT_ONE = 1.0;
    const FLOAT_TWO = 2.0;

    const STRING_ONE = '1';
    const STRING_TWO = '2';

    const ARRAY_ONE = [1];
    const ARRAY_TWO = [2];

    const NULL_NULL = NULL;

}
