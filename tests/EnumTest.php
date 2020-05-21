<?php

namespace PhpEnum\Tests;

class EnumTest extends \PHPUnit\Framework\TestCase
{

    public function testEnum()
    {

        $this->assertEquals(UserEnum::SEX_MAN()->getKey(), 'SEX_MAN');
        $this->assertEquals(UserEnum::SEX_MAN()->getValue(), 1);

        $this->assertTrue(UserEnum::SEX_MAN()->keyEquals('SEX_MAN'));
        $this->assertTrue(UserEnum::SEX_MAN()->valueEquals(1));

        $this->assertEquals(UserEnum::searchKey(1), 'SEX_MAN');
        $this->assertEquals(UserEnum::searchKey(1, 'sex'), 'SEX_MAN');
        $this->assertEquals(UserEnum::searchValue('SEX_MAN'), 1);
        $this->assertEquals(UserEnum::searchValue('SEX_MAN', 'sex'), 1);

        $this->assertTrue(UserEnum::keyExist('SEX_MAN'));
        $this->assertTrue(UserEnum::keyExist('SEX_MAN', 'sex'));
        $this->assertTrue(UserEnum::valueExist(1));
        $this->assertTrue(UserEnum::valueExist(1, 'sex'));

        $this->assertTrue(in_array('SEX_MAN', UserEnum::getKeys()));
        $this->assertTrue(in_array('SEX_MAN', UserEnum::getKeys('sex')));
        $this->assertTrue(in_array(1, UserEnum::getValues()));
        $this->assertTrue(in_array(1, UserEnum::getValues('sex')));

        $this->assertEquals(UserEnum::getSize(), 4);

    }

}