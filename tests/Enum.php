<?php

namespace PhpEnum\Tests;

/**
 * @method static self BOOLEAN_TRUE
 * @method static self BOOLEAN_FALSE
 *
 * @method static self INTEGER_ZERO
 * @method static self INTEGER_ONE
 * @method static self INTEGER_TWO
 *
 * @method static self NUMBER_ZERO
 * @method static self NUMBER_ONE
 *
 * @method static self FLOAT_ZERO
 * @method static self FLOAT_ONE
 *
 * @method static self STRING_EMPTY
 * @method static self STRING_ONE
 *
 * @method static self ARRAY_EMPTY
 * @method static self ARRAY_ONE
 *
 * @method static self NULL_NULL
 */
class Enum extends \PhpEnum\Enum
{

    const BOOLEAN_TRUE = TRUE;
    const BOOLEAN_FALSE = FALSE;

    public const INTEGER_ZERO = 0;
    public const INTEGER_ONE = 1;
    protected const INTEGER_TWO = -2;
    private const INTEGER_THREE = 3;

    const NUMBER_ZERO = 0;
    const NUMBER_ONE = 1;

    const FLOAT_ZERO = 0.0;
    const FLOAT_ONE = 1.0;

    const STRING_EMPTY = '';
    const STRING_ONE = '1';

    const ARRAY_EMPTY = [];
    const ARRAY_ONE = [1];

    const NULL_NULL = NULL;

}
