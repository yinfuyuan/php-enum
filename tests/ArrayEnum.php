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
class ArrayEnum extends \PhpEnum\ArrayEnum
{
    const BOOLEAN_TRUE = [TRUE, 'true'];
    const BOOLEAN_FALSE = [FALSE, 'false'];

    const INTEGER_ZERO = [0, 'zero'];
    const INTEGER_ONE = [1, 'one'];
    const INTEGER_TWO = [-2, 'two'];

    const FLOAT_ZERO = [0.0,'zero'];
    const FLOAT_ONE = [1.0,'one'];

    const STRING_EMPTY = ['', 'empty'];
    const STRING_ONE = ['1', 'one'];

    const ARRAY_EMPTY = [[], 'empty'];
    const ARRAY_ONE = [[1], 'one'];

    const NULL_NULL = [NULL, 'null'];

    protected function scale()
    {
        return 5;
    }
}