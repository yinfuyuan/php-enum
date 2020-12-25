<?php

namespace PhpEnum\Tests;

/**
 * @method static self BOOLEAN_TRUE
 * @method static self BOOLEAN_FALSE
 *
 * @method static self INTEGER_ZERO
 * @method static self INTEGER_ONE
 * @method static self INTEGER_MINUS_TWO
 * @method static self INTEGER_THREE
 *
 * @method static self FLOAT_ZERO
 * @method static self FLOAT_MINUS_POINT_ONE
 * @method static self FLOAT_POINT_ONE
 * @method static self FLOAT_ONE
 *
 * @method static self STRING_EMPTY
 * @method static self STRING_INTEGER_ONE
 * @method static self STRING_ONE
 * @method static self STRING_EOF
 *
 * @method static self ARRAY_EMPTY
 * @method static self ARRAY_ONE
 * @method static self ARRAY_FLOAT_TWO
 * @method static self ARRAY_STRING
 *
 * @method static self NULL_NULL
 */
class Enum extends \PhpEnum\Enum
{
    const BOOLEAN_TRUE = TRUE;
    const BOOLEAN_FALSE = FALSE;

    const INTEGER_ZERO = 0;
    const INTEGER_ONE = 1;
    const INTEGER_MINUS_TWO = -2;
    const INTEGER_THREE = 3;

    const FLOAT_ZERO = 0.0;
    const FLOAT_MINUS_POINT_ONE = -1.0;
    const FLOAT_POINT_ONE = 0.1;
    const FLOAT_ONE = 0.555 + 0.512 - 0.067;

    const STRING_EMPTY = '';
    const STRING_INTEGER_ONE = '1';
    const STRING_ONE = 'one';
    const STRING_EOF = <<<EOT
    This is a very long text.
EOT;

    const ARRAY_EMPTY = [];
    const ARRAY_ONE = [1];
    const ARRAY_FLOAT_TWO = [0.3-0.1=>0.2];
    const ARRAY_STRING = ['This' => ['is' => 'a', ['array']]];

    const NULL_NULL = NULL;

    protected function scale()
    {
        return 5;
    }
}
