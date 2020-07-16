<?php

namespace PhpEnum\Tests;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{

    public function testEnumType()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->value());
        $this->assertFalse(Enum::BOOLEAN_FALSE()->value());
        $this->assertIsInt(Enum::INTEGER_ONE()->value());
        $this->assertIsFloat(Enum::FLOAT_ONE()->value());
        $this->assertIsString(Enum::STRING_ONE()->value());
        $this->assertIsArray(Enum::ARRAY_ONE()->value());
        $this->assertNull(Enum::NULL_NULL()->value());
    }

    public function testEnumName()
    {
        $this->assertEquals(Enum::BOOLEAN_TRUE()->name(), 'BOOLEAN_TRUE');
        $this->assertEquals(Enum::INTEGER_ONE()->name(), 'INTEGER_ONE');
        $this->assertEquals(Enum::FLOAT_ONE()->name(), 'FLOAT_ONE');
        $this->assertEquals(Enum::STRING_ONE()->name(), 'STRING_ONE');
        $this->assertEquals(Enum::ARRAY_ONE()->name(), 'ARRAY_ONE');
        $this->assertEquals(Enum::NULL_NULL()->name(), 'NULL_NULL');
    }

    public function testEnumValue()
    {
        $this->assertEquals(Enum::BOOLEAN_TRUE()->value(), TRUE);
        $this->assertEquals(Enum::INTEGER_ONE()->value(), 1);
        $this->assertEquals(strval(Enum::FLOAT_ONE()->value()), strval(1.0));
        $this->assertEquals(Enum::STRING_ONE()->value(), '1');
        $this->assertEquals(Enum::ARRAY_ONE()->value(), [1]);
        $this->assertEquals(Enum::NULL_NULL()->value(), NULL);
    }

    public function testEnumEquals()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->equals(Enum::byValue(TRUE)));
        $this->assertTrue(Enum::INTEGER_ONE()->equals(Enum::byValue(1, 'INTEGER')));
        $this->assertTrue(Enum::FLOAT_ONE()->equals(Enum::byName('FLOAT_ONE')));
        $this->assertTrue(Enum::STRING_ONE()->equals(Enum::byValue('1')));
        $this->assertTrue(Enum::ARRAY_ONE()->equals(Enum::byValue([1])));
        $this->assertTrue(Enum::NULL_NULL()->equals(Enum::byValue(NULL)));
    }

    public function testEnumNameEquals()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->nameEquals("BOOLEAN_TRUE"));
        $this->assertTrue(Enum::INTEGER_ONE()->nameEquals('INTEGER_ONE'));
        $this->assertTrue(Enum::FLOAT_ONE()->nameEquals('FLOAT_ONE'));
        $this->assertTrue(Enum::STRING_ONE()->nameEquals('STRING_ONE'));
        $this->assertTrue(Enum::ARRAY_ONE()->nameEquals('ARRAY_ONE'));
        $this->assertTrue(Enum::NULL_NULL()->nameEquals('NULL_NULL'));
    }

    public function testEnumValueEquals()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->valueEquals(TRUE));
        $this->assertFalse(Enum::BOOLEAN_FALSE()->valueEquals(TRUE));
        $this->assertTrue(Enum::INTEGER_ONE()->valueEquals(1));
        $this->assertFalse(Enum::INTEGER_ONE()->valueEquals('1'));
        $this->assertTrue(Enum::INTEGER_ONE()->valueEquals(1));
        $this->assertTrue(Enum::STRING_ONE()->valueEquals('1'));
        $this->assertTrue(Enum::ARRAY_ONE()->valueEquals([1]));
    }

    public function testEnumNames()
    {
        $this->assertContains('INTEGER_TWO', Enum::names());
        $this->assertContains('INTEGER_THREE', Enum::names());
        $this->assertNotContains('INTEGER_FOUR', Enum::names());
        $this->assertNotContains('INTEGER_ONE', Enum::names('NUMBER'));
        $this->assertNotContains('INTEGER_TWO', Enum::names('number', false));
        $this->assertEmpty(Enum::names('null'));
        $this->assertNotEmpty(Enum::names('NULL'));
        $this->assertEquals(Enum::names('NULL'), Enum::names('null', false));
    }

    public function testEnumValues()
    {
        $this->assertArrayHasKey('INTEGER_TWO', Enum::values());
        $this->assertArrayHasKey('INTEGER_THREE', Enum::values());
        $this->assertArrayNotHasKey('INTEGER_FOUR', Enum::values());
        $this->assertArrayNotHasKey('INTEGER_ONE', Enum::values('NUMBER'));
        $this->assertArrayNotHasKey('INTEGER_TWO', Enum::values('number', false));
        $this->assertEmpty(Enum::values('null'));
        $this->assertNotEmpty(Enum::values('NULL'));
        $this->assertEquals(Enum::values('NULL'), Enum::values('null', false));
    }

    public function testEnumEnums()
    {
        $this->assertArrayHasKey('INTEGER_TWO', Enum::enums());
        $this->assertArrayHasKey('INTEGER_THREE', Enum::enums());
        $this->assertArrayNotHasKey('INTEGER_FOUR', Enum::enums());
        $this->assertArrayNotHasKey('INTEGER_ONE', Enum::enums('NUMBER'));
        $this->assertArrayNotHasKey('INTEGER_TWO', Enum::enums('number', false));
        $this->assertEmpty(Enum::enums('null'));
        $this->assertNotEmpty(Enum::enums('NULL'));
        $this->assertEquals(Enum::enums('NULL'), Enum::enums('null', false));
    }

    public function testEnumHasName()
    {
        $this->assertTrue(Enum::hasName('BOOLEAN_TRUE'));
        $this->assertTrue(Enum::hasName('INTEGER_TWO'));
        $this->assertTrue(Enum::hasName('INTEGER_THREE'));
        $this->assertFalse(Enum::hasName('INTEGER_FOUR'));
    }

    public function testEnumHasValue()
    {
        $this->assertTrue(Enum::hasValue(TRUE));
        $this->assertTrue(Enum::hasValue(1, 'INTEGER'));
        $this->assertTrue(Enum::hasValue(1, 'number', false));
        $this->assertTrue(Enum::hasValue(2));
        $this->assertTrue(Enum::hasValue(3));
        $this->assertFalse(Enum::hasValue(4));
        $this->assertTrue(Enum::hasValue(NULL));
    }

    public function testEnumByName()
    {
        $this->assertTrue(Enum::byName('BOOLEAN_TRUE')->value());
        $this->assertFalse(Enum::byName('BOOLEAN_FALSE')->value());
        $this->assertNull(Enum::byName('NULL_NULL')->value());
        $this->assertEquals(Enum::byName('INTEGER_THREE')->name(), 'INTEGER_THREE');
        $this->assertNull(Enum::byName('INTEGER_FOUR'));
    }

    public function testEnumByValue()
    {
        $this->assertTrue(Enum::byValue(TRUE)->nameEquals('BOOLEAN_TRUE'));
        $this->assertTrue(Enum::byValue(NULL)->nameEquals('NULL_NULL'));
        $this->assertTrue(Enum::byValue(1, 'INTEGER')->nameEquals('INTEGER_ONE'));
        $this->assertTrue(Enum::byValue(1, 'number', false)->nameEquals('NUMBER_ONE'));
    }

    public function testEnumCount()
    {
        $this->assertCount(Enum::count(), Enum::names());
    }

}