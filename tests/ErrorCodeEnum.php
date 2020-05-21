<?php

namespace PhpEnum\Tests;

/**
 * @method static self OK
 *
 * @method static self UNKNOWN_ERROR
 *
 * @method static self ERROR_DATA_VALIDATION
 * @method static self ERROR_USER_INVALID
 * @method static self ERROR_CONFIG_ERROR
 */
class ErrorCodeEnum extends \PhpEnum\ListEnum
{

    protected static $ENUM_LENGTH = 2;

    const OK = ['0', 'ok'];

    const UNKNOWN_ERROR = ['99999', 'Unknown error'];

    const ERROR_DATA_VALIDATION = ['10047', 'The given data was invalid'];
    const ERROR_USER_INVALID = ['10010', 'User credentials was invalid'];
    const ERROR_CONFIG_ERROR = ['10031', 'Config info is error'];

}