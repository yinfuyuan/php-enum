<?php

namespace PhpEnum\Tests;

/**
 * @method static self CITY_BEIJING
 * @method static self CITY_LIAONING
 * @method static self CITY_SHENYANG
 * @method static self CITY_DALIAN
 */
class CityEnum extends \PhpEnum\ListEnum
{

    protected static $ENUM_LENGTH = 3;

    const CITY_BEIJING = ['110000', '110000', '北京市']; // 北京市
    const CITY_LIAONING = ['22000', '22000', '辽宁省']; // 辽宁省
    const CITY_SHENYANG = ['22000', '210100', '沈阳市']; // 沈阳市
    const CITY_DALIAN = ['22000', '210200', '大连市']; // 大连市

    private $enum_pcode; // 省份编码
    private $enum_code; // 城市编码
    private $enum_name; // 城市名称

    public function getPCode()
    {
        return $this->enum_pcode;
    }

    public function getCode()
    {
        return $this->enum_code;
    }

    public function getName()
    {
        return $this->enum_name;
    }

}
