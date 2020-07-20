<?php

namespace PhpEnum\Tests;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{

    public function testEnumType()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->value());
        $this->assertFalse(Enum::BOOLEAN_FALSE()->value());
        $this->assertIsInt(Enum::INTEGER_ZERO()->value());
        $this->assertIsInt(Enum::INTEGER_ONE()->value());
        $this->assertIsInt(Enum::INTEGER_TWO()->value());
        $this->assertIsNumeric(Enum::NUMBER_ZERO()->value());
        $this->assertIsNumeric(Enum::NUMBER_ONE()->value());
        $this->assertIsFloat(Enum::FLOAT_ZERO()->value());
        $this->assertIsFloat(Enum::FLOAT_ONE()->value());
        $this->assertIsString(Enum::STRING_EMPTY()->value());
        $this->assertIsString(Enum::STRING_ONE()->value());
        $this->assertIsArray(Enum::ARRAY_EMPTY()->value());
        $this->assertIsArray(Enum::ARRAY_ONE()->value());
        $this->assertNull(Enum::NULL_NULL()->value());
    }

    public function testEnumName()
    {
        $this->assertEquals(Enum::BOOLEAN_TRUE()->name(), 'BOOLEAN_TRUE');
        $this->assertEquals(Enum::BOOLEAN_FALSE()->name(), 'BOOLEAN_FALSE');
        $this->assertEquals(Enum::INTEGER_ZERO()->name(), 'INTEGER_ZERO');
        $this->assertEquals(Enum::INTEGER_ONE()->name(), 'INTEGER_ONE');
        $this->assertEquals(Enum::INTEGER_TWO()->name(), 'INTEGER_TWO');
        $this->assertEquals(Enum::NUMBER_ZERO()->name(), 'NUMBER_ZERO');
        $this->assertEquals(Enum::NUMBER_ONE()->name(), 'NUMBER_ONE');
        $this->assertEquals(Enum::FLOAT_ZERO()->name(), 'FLOAT_ZERO');
        $this->assertEquals(Enum::FLOAT_ONE()->name(), 'FLOAT_ONE');
        $this->assertEquals(Enum::STRING_EMPTY()->name(), 'STRING_EMPTY');
        $this->assertEquals(Enum::STRING_ONE()->name(), 'STRING_ONE');
        $this->assertEquals(Enum::ARRAY_EMPTY()->name(), 'ARRAY_EMPTY');
        $this->assertEquals(Enum::ARRAY_ONE()->name(), 'ARRAY_ONE');
        $this->assertEquals(Enum::NULL_NULL()->name(), 'NULL_NULL');
    }

    public function testEnumValue()
    {
        $this->assertEquals(Enum::BOOLEAN_TRUE()->value(), TRUE);
        $this->assertEquals(Enum::BOOLEAN_FALSE()->value(), FALSE);
        $this->assertEquals(Enum::INTEGER_ZERO()->value(), 0);
        $this->assertEquals(Enum::INTEGER_ONE()->value(), 1);
        $this->assertEquals(Enum::INTEGER_TWO()->value(), -2);
        $this->assertEquals(Enum::NUMBER_ZERO()->value(), 0);
        $this->assertEquals(Enum::NUMBER_ONE()->value(), 1);
        $this->assertEquals(strval(Enum::FLOAT_ZERO()->value()), strval(0.0));
        $this->assertEquals(strval(Enum::FLOAT_ONE()->value()), strval(1.0));
        $this->assertEquals(Enum::STRING_EMPTY()->value(), '');
        $this->assertEquals(Enum::STRING_ONE()->value(), '1');
        $this->assertEquals(Enum::ARRAY_EMPTY()->value(), []);
        $this->assertEquals(Enum::ARRAY_ONE()->value(), [1]);
        $this->assertEquals(Enum::NULL_NULL()->value(), NULL);
    }

    public function testEnumNameEquals()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->nameEquals('BOOLEAN_TRUE'));
        $this->assertTrue(Enum::BOOLEAN_FALSE()->nameEquals('BOOLEAN_FALSE'));
        $this->assertTrue(Enum::INTEGER_ZERO()->nameEquals('INTEGER_ZERO'));
        $this->assertTrue(Enum::INTEGER_ONE()->nameEquals('INTEGER_ONE'));
        $this->assertTrue(Enum::INTEGER_TWO()->nameEquals('INTEGER_TWO'));
        $this->assertTrue(Enum::NUMBER_ZERO()->nameEquals('NUMBER_ZERO'));
        $this->assertTrue(Enum::NUMBER_ONE()->nameEquals('NUMBER_ONE'));
        $this->assertTrue(Enum::FLOAT_ZERO()->nameEquals('FLOAT_ZERO'));
        $this->assertTrue(Enum::FLOAT_ONE()->nameEquals('FLOAT_ONE'));
        $this->assertTrue(Enum::STRING_EMPTY()->nameEquals('STRING_EMPTY'));
        $this->assertTrue(Enum::STRING_ONE()->nameEquals('STRING_ONE'));
        $this->assertTrue(Enum::ARRAY_EMPTY()->nameEquals('ARRAY_EMPTY'));
        $this->assertTrue(Enum::ARRAY_ONE()->nameEquals('ARRAY_ONE'));
        $this->assertTrue(Enum::NULL_NULL()->nameEquals('NULL_NULL'));
    }

    public function testEnumValueEquals()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->valueEquals(TRUE));
        $this->assertTrue(Enum::BOOLEAN_FALSE()->valueEquals(FALSE));
        $this->assertTrue(Enum::INTEGER_ZERO()->valueEquals(0));
        $this->assertTrue(Enum::INTEGER_ONE()->valueEquals(1));
        $this->assertTrue(Enum::INTEGER_TWO()->valueEquals(-2));
        $this->assertTrue(Enum::NUMBER_ZERO()->valueEquals(0));
        $this->assertTrue(Enum::NUMBER_ONE()->valueEquals(1));
        $this->assertTrue(Enum::FLOAT_ZERO()->valueEquals(0.0)); // The results are not credible.
        $this->assertTrue(Enum::FLOAT_ONE()->valueEquals(1.0)); // The results are not credible.
        $this->assertTrue(Enum::STRING_EMPTY()->valueEquals(''));
        $this->assertTrue(Enum::STRING_ONE()->valueEquals('1'));
        $this->assertTrue(Enum::ARRAY_EMPTY()->valueEquals([]));
        $this->assertTrue(Enum::ARRAY_ONE()->valueEquals([1]));
        $this->assertTrue(Enum::NULL_NULL()->valueEquals(NULL));
    }

    public function testEnumNames()
    {
        $names = Enum::names();
        $this->assertContains('BOOLEAN_TRUE', $names);
        $this->assertContains('BOOLEAN_FALSE', $names);
        $this->assertContains('INTEGER_ZERO', $names);
        $this->assertContains('INTEGER_ONE', $names);
        $this->assertContains('INTEGER_TWO', $names);
        $this->assertContains('NUMBER_ZERO', $names);
        $this->assertContains('NUMBER_ONE', $names);
        $this->assertContains('FLOAT_ZERO', $names);
        $this->assertContains('FLOAT_ONE', $names);
        $this->assertContains('STRING_EMPTY', $names);
        $this->assertContains('STRING_ONE', $names);
        $this->assertContains('ARRAY_EMPTY', $names);
        $this->assertContains('ARRAY_ONE', $names);
        $this->assertContains('NULL_NULL', $names);
        $this->assertCount(2, Enum::names('BOOLEAN'));
        $this->assertCount(2, Enum::names('boolean', false));
        $this->assertCount(3, Enum::names('INTEGER'));
        $this->assertCount(3, Enum::names('integer', false));
        $this->assertCount(2, Enum::names('NUMBER'));
        $this->assertCount(2, Enum::names('number', false));
        $this->assertCount(2, Enum::names('FLOAT'));
        $this->assertCount(2, Enum::names('float', false));
        $this->assertCount(2, Enum::names('STRING'));
        $this->assertCount(2, Enum::names('string', false));
        $this->assertCount(2, Enum::names('ARRAY'));
        $this->assertCount(2, Enum::names('array', false));
        $this->assertCount(1, Enum::names('NULL'));
        $this->assertCount(1, Enum::names('null', false));
    }

    public function testEnumValues()
    {
        $values = Enum::values();
        $this->assertEquals($values['BOOLEAN_TRUE'], TRUE);
        $this->assertEquals($values['BOOLEAN_FALSE'], FALSE);
        $this->assertEquals($values['INTEGER_ZERO'], 0);
        $this->assertEquals($values['INTEGER_ONE'], 1);
        $this->assertEquals($values['INTEGER_TWO'], -2);
        $this->assertEquals($values['NUMBER_ZERO'], 0);
        $this->assertEquals($values['NUMBER_ONE'], 1);
        $this->assertEquals(strval($values['FLOAT_ZERO']), strval(0.0));
        $this->assertEquals(strval($values['FLOAT_ONE']), strval(1.0));
        $this->assertEquals($values['STRING_EMPTY'], '');
        $this->assertEquals($values['STRING_ONE'], '1');
        $this->assertEquals($values['ARRAY_EMPTY'], []);
        $this->assertEquals($values['ARRAY_ONE'], [1]);
        $this->assertEquals($values['NULL_NULL'], NULL);
        $this->assertCount(2, Enum::values('BOOLEAN'));
        $this->assertCount(2, Enum::values('boolean', false));
        $this->assertCount(3, Enum::values('INTEGER'));
        $this->assertCount(3, Enum::values('integer', false));
        $this->assertCount(2, Enum::values('NUMBER'));
        $this->assertCount(2, Enum::values('number', false));
        $this->assertCount(2, Enum::values('FLOAT'));
        $this->assertCount(2, Enum::values('float', false));
        $this->assertCount(2, Enum::values('STRING'));
        $this->assertCount(2, Enum::values('string', false));
        $this->assertCount(2, Enum::values('ARRAY'));
        $this->assertCount(2, Enum::values('array', false));
        $this->assertCount(1, Enum::values('NULL'));
        $this->assertCount(1, Enum::values('null', false));
    }

    public function testEnumEnums()
    {
        $enums = Enum::enums();
        $this->assertTrue(Enum::BOOLEAN_TRUE()->equals($enums['BOOLEAN_TRUE']));
        $this->assertTrue(Enum::BOOLEAN_FALSE()->equals($enums['BOOLEAN_FALSE']));
        $this->assertTrue(Enum::INTEGER_ZERO()->equals($enums['INTEGER_ZERO']));
        $this->assertTrue(Enum::INTEGER_ONE()->equals($enums['INTEGER_ONE']));
        $this->assertTrue(Enum::INTEGER_TWO()->equals($enums['INTEGER_TWO']));
        $this->assertTrue(Enum::NUMBER_ZERO()->equals($enums['NUMBER_ZERO']));
        $this->assertTrue(Enum::NUMBER_ONE()->equals($enums['NUMBER_ONE']));
        $this->assertTrue(Enum::FLOAT_ZERO()->equals($enums['FLOAT_ZERO']));
        $this->assertTrue(Enum::FLOAT_ONE()->equals($enums['FLOAT_ONE']));
        $this->assertTrue(Enum::STRING_EMPTY()->equals($enums['STRING_EMPTY']));
        $this->assertTrue(Enum::STRING_ONE()->equals($enums['STRING_ONE']));
        $this->assertTrue(Enum::ARRAY_EMPTY()->equals($enums['ARRAY_EMPTY']));
        $this->assertTrue(Enum::ARRAY_ONE()->equals($enums['ARRAY_ONE']));
        $this->assertTrue(Enum::NULL_NULL()->equals($enums['NULL_NULL']));
        $this->assertCount(2, Enum::enums('BOOLEAN'));
        $this->assertCount(2, Enum::enums('boolean', false));
        $this->assertCount(3, Enum::enums('INTEGER'));
        $this->assertCount(3, Enum::enums('integer', false));
        $this->assertCount(2, Enum::enums('NUMBER'));
        $this->assertCount(2, Enum::enums('number', false));
        $this->assertCount(2, Enum::enums('FLOAT'));
        $this->assertCount(2, Enum::enums('float', false));
        $this->assertCount(2, Enum::enums('STRING'));
        $this->assertCount(2, Enum::enums('string', false));
        $this->assertCount(2, Enum::enums('ARRAY'));
        $this->assertCount(2, Enum::enums('array', false));
        $this->assertCount(1, Enum::enums('NULL'));
        $this->assertCount(1, Enum::enums('null', false));
    }

    public function testEnumHasName()
    {
        $this->assertTrue(Enum::hasName('BOOLEAN_TRUE'));
        $this->assertTrue(Enum::hasName('BOOLEAN_FALSE'));
        $this->assertTrue(Enum::hasName('INTEGER_ZERO'));
        $this->assertTrue(Enum::hasName('INTEGER_ONE'));
        $this->assertTrue(Enum::hasName('INTEGER_TWO'));
        $this->assertTrue(Enum::hasName('NUMBER_ZERO'));
        $this->assertTrue(Enum::hasName('NUMBER_ONE'));
        $this->assertTrue(Enum::hasName('FLOAT_ZERO'));
        $this->assertTrue(Enum::hasName('FLOAT_ONE'));
        $this->assertTrue(Enum::hasName('STRING_EMPTY'));
        $this->assertTrue(Enum::hasName('STRING_ONE'));
        $this->assertTrue(Enum::hasName('ARRAY_EMPTY'));
        $this->assertTrue(Enum::hasName('ARRAY_ONE'));
        $this->assertTrue(Enum::hasName('NULL_NULL'));
    }

    public function testEnumHasValue()
    {
        $this->assertTrue(Enum::hasValue(TRUE));
        $this->assertTrue(Enum::hasValue(FALSE));
        $this->assertTrue(Enum::hasValue(0));
        $this->assertTrue(Enum::hasValue(1));
        $this->assertTrue(Enum::hasValue(-2));
        $this->assertTrue(Enum::hasValue(0.0));
        $this->assertTrue(Enum::hasValue(1.0));
        $this->assertTrue(Enum::hasValue(''));
        $this->assertTrue(Enum::hasValue('1'));
        $this->assertTrue(Enum::hasValue([]));
        $this->assertTrue(Enum::hasValue([1]));
        $this->assertTrue(Enum::hasValue(NULL));
    }

    public function testEnumByName()
    {
        $this->assertTrue(Enum::byName('BOOLEAN_TRUE')->equals(Enum::BOOLEAN_TRUE()));
        $this->assertTrue(Enum::byName('BOOLEAN_FALSE')->equals(Enum::BOOLEAN_FALSE()));
        $this->assertTrue(Enum::byName('INTEGER_ZERO')->equals(Enum::INTEGER_ZERO()));
        $this->assertTrue(Enum::byName('INTEGER_ONE')->equals(Enum::INTEGER_ONE()));
        $this->assertTrue(Enum::byName('INTEGER_TWO')->equals(Enum::INTEGER_TWO()));
        $this->assertTrue(Enum::byName('NUMBER_ZERO')->equals(Enum::NUMBER_ZERO()));
        $this->assertTrue(Enum::byName('NUMBER_ONE')->equals(Enum::NUMBER_ONE()));
        $this->assertTrue(Enum::byName('FLOAT_ZERO')->equals(Enum::FLOAT_ZERO()));
        $this->assertTrue(Enum::byName('FLOAT_ONE')->equals(Enum::FLOAT_ONE()));
        $this->assertTrue(Enum::byName('STRING_EMPTY')->equals(Enum::STRING_EMPTY()));
        $this->assertTrue(Enum::byName('STRING_ONE')->equals(Enum::STRING_ONE()));
        $this->assertTrue(Enum::byName('ARRAY_EMPTY')->equals(Enum::ARRAY_EMPTY()));
        $this->assertTrue(Enum::byName('ARRAY_ONE')->equals(Enum::ARRAY_ONE()));
        $this->assertTrue(Enum::byName('NULL_NULL')->equals(Enum::NULL_NULL()));
    }

    public function testEnumByValue()
    {
        $this->assertTrue(Enum::byValue(TRUE)->equals(Enum::BOOLEAN_TRUE()));
        $this->assertTrue(Enum::byValue(FALSE)->equals(Enum::BOOLEAN_FALSE()));
        $this->assertTrue(Enum::byValue(0, 'INTEGER')->equals(Enum::INTEGER_ZERO()));
        $this->assertTrue(Enum::byValue(1, 'integer', false)->equals(Enum::INTEGER_ONE()));
        $this->assertTrue(Enum::byValue(-2, 'I')->equals(Enum::INTEGER_TWO()));
        $this->assertTrue(Enum::byValue(0, 'NUMBER')->equals(Enum::NUMBER_ZERO()));
        $this->assertTrue(Enum::byValue(1, 'number', false)->equals(Enum::NUMBER_ONE()));
        $this->assertTrue(Enum::byValue(0.0)->equals(Enum::FLOAT_ZERO())); // The results are not credible.
        $this->assertTrue(Enum::byValue(1.0)->equals(Enum::FLOAT_ONE())); // The results are not credible.
        $this->assertTrue(Enum::byValue('')->equals(Enum::STRING_EMPTY()));
        $this->assertTrue(Enum::byValue('1')->equals(Enum::STRING_ONE()));
        $this->assertTrue(Enum::byValue([])->equals(Enum::ARRAY_EMPTY()));
        $this->assertTrue(Enum::byValue([1])->equals(Enum::ARRAY_ONE()));
        $this->assertTrue(Enum::byValue(NULL)->equals(Enum::NULL_NULL()));
    }

    public function testEnumCount()
    {
        $this->assertCount(Enum::count(), Enum::names());
        $this->assertCount(Enum::count(), Enum::values());
        $this->assertCount(Enum::count(), Enum::enums());
        $this->assertCount(Enum::count('BOOLEAN'), Enum::names('BOOLEAN'));
        $this->assertCount(Enum::count('boolean', false), Enum::names('boolean', false));
        $this->assertCount(Enum::count('INTEGER'), Enum::names('INTEGER'));
        $this->assertCount(Enum::count('integer', false), Enum::names('integer', false));
        $this->assertCount(Enum::count('FLOAT'), Enum::names('FLOAT'));
        $this->assertCount(Enum::count('float', false), Enum::names('float', false));
        $this->assertCount(Enum::count('STRING'), Enum::names('STRING'));
        $this->assertCount(Enum::count('string', false), Enum::names('string', false));
        $this->assertCount(Enum::count('ARRAY'), Enum::names('ARRAY'));
        $this->assertCount(Enum::count('array', false), Enum::names('array', false));
        $this->assertCount(Enum::count('NULL'), Enum::names('NULL'));
        $this->assertCount(Enum::count('null', false), Enum::names('null', false));
    }

    public function testEnumSpecial()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->valueEquals(Enum::INTEGER_ONE()->value(), false));
        $this->assertTrue(Enum::INTEGER_ONE()->valueEquals(Enum::FLOAT_ONE()->value(), false));
        $this->assertTrue(Enum::FLOAT_ONE()->valueEquals(Enum::STRING_ONE()->value(), false));
        $this->assertTrue(Enum::BOOLEAN_FALSE()->valueEquals(Enum::INTEGER_ZERO()->value(), false));
        $this->assertTrue(Enum::INTEGER_ZERO()->valueEquals(Enum::FLOAT_ZERO()->value(), false));
        $this->assertTrue(Enum::FLOAT_ZERO()->valueEquals(Enum::STRING_EMPTY()->value(), false));
        $this->assertTrue(Enum::STRING_EMPTY()->valueEquals(Enum::NULL_NULL()->value(), false));
        $this->assertEmpty(Enum::names('null'));
        $this->assertNotEmpty(Enum::names('NULL'));
        $this->assertEquals(Enum::names('NULL'), Enum::names('null', false));
        $this->assertFalse(Enum::hasName('INTEGER_THREE'));
        $this->assertFalse(Enum::hasName('INTEGER_FOUR'));
        $this->assertTrue(Enum::hasValue(0, 'INTEGER'));
        $this->assertTrue(Enum::hasValue(0, 'NUMBER'));
        $this->assertTrue(Enum::byValue(0)->equals(Enum::INTEGER_ZERO()));
        $this->assertFalse(Enum::byValue(0)->equals(Enum::NUMBER_ZERO()));
    }

}