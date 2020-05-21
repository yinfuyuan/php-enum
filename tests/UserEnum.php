<?php

namespace PhpEnum\Tests;

/**
 * @method static self SEX_MAN
 * @method static self SEX_WOMAN
 *
 * @method static self STATUS_NORMAL
 * @method static self STATUS_INVALID
 */
class UserEnum extends \PhpEnum\Enum
{

    const SEX_MAN = 1;
    const SEX_WOMAN = 2;

    const STATUS_NORMAL = 1;
    const STATUS_INVALID = 9;

}
