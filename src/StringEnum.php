<?php

namespace PhpEnum;

/**
 * Class StringEnum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 * @license https://opensource.org/licenses/GPL-3.0
 */
abstract class StringEnum extends Enum
{

    /**
     * Create a new string enum instance.
     *
     * @param array $attribute
     * @return void
     *
     * @throws \Exception
     */
    public function __construct($attribute)
    {
        throw new \Exception('Method is not implemented');
    }

}
