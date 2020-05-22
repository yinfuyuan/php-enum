<?php

namespace PhpEnum\Tests;

class ListEnumTest extends \PHPUnit\Framework\TestCase
{

    public function testListEnumGet()
    {
        $this->assertEquals(CityEnum::CITY_SHENYANG()->getKey(), 'CITY_SHENYANG');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->getValue(), ['22000', '210100', '沈阳市']);
        $this->assertEquals(CityEnum::CITY_SHENYANG()->get(0), '22000');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->get(1), '210100');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->get(2), '沈阳市');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->A, '22000');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->B, '210100');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->C, '沈阳市');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->getPCode(), '22000');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->getCode(), '210100');
        $this->assertEquals(CityEnum::CITY_SHENYANG()->getName(), '沈阳市');
    }

    public function testListEnumEquals()
    {
        $this->assertTrue(CityEnum::CITY_SHENYANG()->keyEquals('CITY_SHENYANG'));
        $this->assertTrue(CityEnum::CITY_SHENYANG()->valueEquals(['22000', '210100', '沈阳市']));
    }

    public function testListEnumSearch()
    {
        $this->assertEquals(CityEnum::searchKey(['22000', '210100', '沈阳市']), 'CITY_SHENYANG');
        $this->assertEquals(CityEnum::searchKey(['22000', '210100', '沈阳市'], 'city'), 'CITY_SHENYANG');
        $this->assertEquals(CityEnum::searchValue('CITY_SHENYANG'), ['22000', '210100', '沈阳市']);
        $this->assertEquals(CityEnum::searchValue('CITY_SHENYANG', 'city'), ['22000', '210100', '沈阳市']);
    }

    public function testListEnumExist()
    {
        $this->assertTrue(CityEnum::keyExist('CITY_SHENYANG'));
        $this->assertTrue(CityEnum::keyExist('CITY_SHENYANG', 'city'));
        $this->assertTrue(CityEnum::valueExist(['22000', '210100', '沈阳市']));
        $this->assertTrue(CityEnum::valueExist(['22000', '210100', '沈阳市'], 'city'));
    }

    public function testListEnumGets()
    {
        $this->assertTrue(in_array('CITY_SHENYANG', CityEnum::getKeys()));
        $this->assertTrue(in_array('CITY_SHENYANG', CityEnum::getKeys('city')));
        $this->assertTrue(in_array(['22000', '210100', '沈阳市'], CityEnum::getValues()));
        $this->assertTrue(in_array(['22000', '210100', '沈阳市'], CityEnum::getValues('city')));
    }

    public function testListEnumRelations()
    {
        $this->assertEquals(CityEnum::CITY_SHENYANG()->searchRelations(0, 1)['CITY_LIAONING'], ['22000', '22000', '辽宁省']);
        $this->assertTrue(in_array(['22000', '210100', '沈阳市'], CityEnum::CITY_LIAONING()->searchRelations(1, 0)));
    }

    public function testListEnumSize()
    {
        $this->assertEquals(CityEnum::getSize(), 4);
    }

    public function testListEnumLength()
    {
        $this->assertEquals(CityEnum::getLength(), 3);
    }

}