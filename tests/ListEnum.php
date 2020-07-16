<?php

namespace PhpEnum\Tests;

/**
 * @method static self CITY_BEIJING
 * @method static self CITY_LIAONING
 * @method static self CITY_SHENYANG
 * @method static self CITY_DALIAN
 */
class ListEnum extends \PhpEnum\ListEnum
{

    protected static $ENUM_LENGTH = 3;

    const CITY_BEIJING = [110000, 110000, 'beijingshi']; // beijingshi
    const CITY_LIAONING = [0, 22000, 'liaoningsheng']; // liaoningsheng
    const CITY_SHENYANG = [22000, 210100, 'shengyangshi']; // shengyangshi
    const CITY_DALIAN = [22000, 210200, 'dalianshi']; // dalianshi

    private $pcode; // province code
    private $code; // city code
    private $name; // city name

    /**
     * @inheritDoc
     */
    public function ListEnum($list)
    {
        list($this->pcode, $this->code, $this->name) = $list;
    }

    /**
     * @inheritDoc
     */
    public static function length()
    {
        return 3;
    }

    public function getPCode()
    {
        return $this->pcode;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

}
