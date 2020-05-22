<?php

namespace PhpEnum\Tests;

class ArrayEnumTest extends \PHPUnit\Framework\TestCase
{

    public function testArrayEnumGet()
    {
        $this->assertEquals(ErrorCodeEnum::OK()->get(0), '0');
        $this->assertEquals(ErrorCodeEnum::OK()->get(1), 'ok');
        $this->assertEquals(ErrorCodeEnum::OK()->A, '0');
        $this->assertEquals(ErrorCodeEnum::OK()->B, 'ok');
        $this->assertEquals(ErrorCodeEnum::OK()->getKey(), '0');
        $this->assertEquals(ErrorCodeEnum::OK()->getValue(), 'ok');
        $this->assertEquals(ErrorCodeEnum::OK()->getEnumKey(), 'OK');
        $this->assertEquals(ErrorCodeEnum::OK()->getEnumValue(), ['0', 'ok']);
    }

    public function testArrayEnumEquals()
    {
        $this->assertTrue(ErrorCodeEnum::OK()->keyEquals('0'));
        $this->assertTrue(ErrorCodeEnum::OK()->valueEquals('ok'));
    }

    public function testArrayEnumSearch()
    {
        $this->assertEquals(ErrorCodeEnum::searchKey('The given data was invalid'), '10047');
        $this->assertEquals(ErrorCodeEnum::searchKey('The given data was invalid', 'error'), '10047');
        $this->assertEquals(ErrorCodeEnum::searchValue('10047'), 'The given data was invalid');
        $this->assertEquals(ErrorCodeEnum::searchValue('10047', 'error'), 'The given data was invalid');
    }

    public function testArrayEnumExist()
    {
        $this->assertTrue(ErrorCodeEnum::keyExist('0'));
        $this->assertTrue(ErrorCodeEnum::keyExist('10047', 'error'));
        $this->assertTrue(ErrorCodeEnum::valueExist('ok'));
        $this->assertTrue(ErrorCodeEnum::valueExist('Unknown error', 'unknown'));
    }

    public function testArrayEnumGets()
    {
        $this->assertTrue(in_array('0', ErrorCodeEnum::getKeys()));
        $this->assertTrue(in_array('10047', ErrorCodeEnum::getKeys('error')));
        $this->assertTrue(in_array('ok', ErrorCodeEnum::getValues()));
        $this->assertTrue(in_array('Unknown error', ErrorCodeEnum::getValues('unknown')));
    }

    public function testArrayEnumSize()
    {
        $this->assertEquals(ErrorCodeEnum::getSize(), 5);
    }

    public function testArrayEnumLength()
    {
        $this->assertEquals(ErrorCodeEnum::getLength(), 2);
    }

}