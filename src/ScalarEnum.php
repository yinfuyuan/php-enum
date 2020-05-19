<?php

namespace PhpEnum;

/**
 * Class ScalarEnum
 *
 * @author yinfuyuan <yinfuyuan@gmail.com>
 * @link https://github.com/yinfuyuan/php-enum
 * @license https://opensource.org/licenses/GPL-3.0
 */
abstract class ScalarEnum extends Enum
{

    /**
     * Create a new scalar enum instance.
     *
     * @param mixed $attribute
     * @return void
     *
     * @throws \Exception
     */
    public function __construct($attribute)
    {
        throw new \Exception('Method is not implemented');
    }

}
