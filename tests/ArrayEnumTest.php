<?php

namespace PhpEnum\Tests;

use PHPUnit\Framework\TestCase;

class ArrayEnumTest extends TestCase
{

    public function testEnumType()
    {
        $this->assertTrue(ArrayEnum::BOOLEAN_TRUE()->getKey());
        $this->assertFalse(ArrayEnum::BOOLEAN_FALSE()->getKey());
        $this->assertIsInt(ArrayEnum::INTEGER_ZERO()->getKey());
        $this->assertIsInt(ArrayEnum::INTEGER_ONE()->getKey());
        $this->assertIsInt(ArrayEnum::INTEGER_TWO()->getKey());
        $this->assertIsFloat(ArrayEnum::FLOAT_ZERO()->getKey());
        $this->assertIsFloat(ArrayEnum::FLOAT_ONE()->getKey());
        $this->assertIsString(ArrayEnum::STRING_EMPTY()->getKey());
        $this->assertIsString(ArrayEnum::STRING_ONE()->getKey());
        $this->assertIsArray(ArrayEnum::ARRAY_EMPTY()->getKey());
        $this->assertIsArray(ArrayEnum::ARRAY_ONE()->getKey());
        $this->assertNull(ArrayEnum::NULL_NULL()->getKey());
    }

    public function testEnumName()
    {
        $this->assertEquals(ArrayEnum::BOOLEAN_TRUE()->name(), 'BOOLEAN_TRUE');
        $this->assertEquals(ArrayEnum::BOOLEAN_FALSE()->name(), 'BOOLEAN_FALSE');
        $this->assertEquals(ArrayEnum::INTEGER_ZERO()->name(), 'INTEGER_ZERO');
        $this->assertEquals(ArrayEnum::INTEGER_ONE()->name(), 'INTEGER_ONE');
        $this->assertEquals(ArrayEnum::INTEGER_TWO()->name(), 'INTEGER_TWO');
        $this->assertEquals(ArrayEnum::FLOAT_ZERO()->name(), 'FLOAT_ZERO');
        $this->assertEquals(ArrayEnum::FLOAT_ONE()->name(), 'FLOAT_ONE');
        $this->assertEquals(ArrayEnum::STRING_EMPTY()->name(), 'STRING_EMPTY');
        $this->assertEquals(ArrayEnum::STRING_ONE()->name(), 'STRING_ONE');
        $this->assertEquals(ArrayEnum::ARRAY_EMPTY()->name(), 'ARRAY_EMPTY');
        $this->assertEquals(ArrayEnum::ARRAY_ONE()->name(), 'ARRAY_ONE');
        $this->assertEquals(ArrayEnum::NULL_NULL()->name(), 'NULL_NULL');
    }

    public function testEnumKey()
    {
        $this->assertEquals(ArrayEnum::BOOLEAN_TRUE()->getKey(), TRUE);
        $this->assertEquals(ArrayEnum::BOOLEAN_FALSE()->getKey(), FALSE);
        $this->assertEquals(ArrayEnum::INTEGER_ZERO()->getKey(), 0);
        $this->assertEquals(ArrayEnum::INTEGER_ONE()->getKey(), 1);
        $this->assertEquals(ArrayEnum::INTEGER_TWO()->getKey(), -2);
        $this->assertEquals(strval(ArrayEnum::FLOAT_ZERO()->getKey()), strval(0.0));
        $this->assertEquals(strval(ArrayEnum::FLOAT_ONE()->getKey()), strval(1.0));
        $this->assertEquals(ArrayEnum::STRING_EMPTY()->getKey(), '');
        $this->assertEquals(ArrayEnum::STRING_ONE()->getKey(), '1');
        $this->assertEquals(ArrayEnum::ARRAY_EMPTY()->getKey(), []);
        $this->assertEquals(ArrayEnum::ARRAY_ONE()->getKey(), [1]);
        $this->assertEquals(ArrayEnum::NULL_NULL()->getKey(), NULL);
    }

    public function testEnumValue()
    {
        $this->assertEquals(ArrayEnum::BOOLEAN_TRUE()->getValue(), 'true');
        $this->assertEquals(ArrayEnum::BOOLEAN_FALSE()->getValue(), 'false');
        $this->assertEquals(ArrayEnum::INTEGER_ZERO()->getValue(), 'zero');
        $this->assertEquals(ArrayEnum::INTEGER_ONE()->getValue(), 'one');
        $this->assertEquals(ArrayEnum::INTEGER_TWO()->getValue(), 'two');
        $this->assertEquals(ArrayEnum::FLOAT_ZERO()->getValue(), 'zero');
        $this->assertEquals(ArrayEnum::FLOAT_ONE()->getValue(), 'one');
        $this->assertEquals(ArrayEnum::STRING_EMPTY()->getValue(), 'empty');
        $this->assertEquals(ArrayEnum::STRING_ONE()->getValue(), 'one');
        $this->assertEquals(ArrayEnum::ARRAY_EMPTY()->getValue(), 'empty');
        $this->assertEquals(ArrayEnum::ARRAY_ONE()->getValue(), 'one');
        $this->assertEquals(ArrayEnum::NULL_NULL()->getValue(), 'null');
    }

    public function testEnumNameEquals()
    {
        $this->assertTrue(ArrayEnum::BOOLEAN_TRUE()->nameEquals('BOOLEAN_TRUE'));
        $this->assertTrue(ArrayEnum::BOOLEAN_FALSE()->nameEquals('BOOLEAN_FALSE'));
        $this->assertTrue(ArrayEnum::INTEGER_ZERO()->nameEquals('INTEGER_ZERO'));
        $this->assertTrue(ArrayEnum::INTEGER_ONE()->nameEquals('INTEGER_ONE'));
        $this->assertTrue(ArrayEnum::INTEGER_TWO()->nameEquals('INTEGER_TWO'));
        $this->assertTrue(ArrayEnum::FLOAT_ZERO()->nameEquals('FLOAT_ZERO'));
        $this->assertTrue(ArrayEnum::FLOAT_ONE()->nameEquals('FLOAT_ONE'));
        $this->assertTrue(ArrayEnum::STRING_EMPTY()->nameEquals('STRING_EMPTY'));
        $this->assertTrue(ArrayEnum::STRING_ONE()->nameEquals('STRING_ONE'));
        $this->assertTrue(ArrayEnum::ARRAY_EMPTY()->nameEquals('ARRAY_EMPTY'));
        $this->assertTrue(ArrayEnum::ARRAY_ONE()->nameEquals('ARRAY_ONE'));
        $this->assertTrue(ArrayEnum::NULL_NULL()->nameEquals('NULL_NULL'));
    }

    public function testEnumKeyEquals()
    {
        $this->assertTrue(ArrayEnum::BOOLEAN_TRUE()->keyEquals(TRUE));
        $this->assertTrue(ArrayEnum::BOOLEAN_FALSE()->keyEquals(FALSE));
        $this->assertTrue(ArrayEnum::INTEGER_ZERO()->keyEquals(0));
        $this->assertTrue(ArrayEnum::INTEGER_ONE()->keyEquals(1));
        $this->assertTrue(ArrayEnum::INTEGER_TWO()->keyEquals(-2));
        $this->assertTrue(ArrayEnum::FLOAT_ZERO()->keyEquals(0.0)); // The results are not credible.
        $this->assertTrue(ArrayEnum::FLOAT_ONE()->keyEquals(1.0)); // The results are not credible.
        $this->assertTrue(ArrayEnum::STRING_EMPTY()->keyEquals(''));
        $this->assertTrue(ArrayEnum::STRING_ONE()->keyEquals('1'));
        $this->assertTrue(ArrayEnum::ARRAY_EMPTY()->keyEquals([]));
        $this->assertTrue(ArrayEnum::ARRAY_ONE()->keyEquals([1]));
        $this->assertTrue(ArrayEnum::NULL_NULL()->keyEquals(NULL));
    }

    public function testEnumValueEquals()
    {
        $this->assertTrue(ArrayEnum::BOOLEAN_TRUE()->valueEquals('true'));
        $this->assertTrue(ArrayEnum::BOOLEAN_FALSE()->valueEquals('false'));
        $this->assertTrue(ArrayEnum::INTEGER_ZERO()->valueEquals('zero'));
        $this->assertTrue(ArrayEnum::INTEGER_ONE()->valueEquals('one'));
        $this->assertTrue(ArrayEnum::INTEGER_TWO()->valueEquals('two'));
        $this->assertTrue(ArrayEnum::FLOAT_ZERO()->valueEquals('zero'));
        $this->assertTrue(ArrayEnum::FLOAT_ONE()->valueEquals('one'));
        $this->assertTrue(ArrayEnum::STRING_EMPTY()->valueEquals('empty'));
        $this->assertTrue(ArrayEnum::STRING_ONE()->valueEquals('one'));
        $this->assertTrue(ArrayEnum::ARRAY_EMPTY()->valueEquals('empty'));
        $this->assertTrue(ArrayEnum::ARRAY_ONE()->valueEquals('one'));
        $this->assertTrue(ArrayEnum::NULL_NULL()->valueEquals('null'));
    }

    public function testEnumNames()
    {
        $names = ArrayEnum::names();
        $this->assertContains('BOOLEAN_TRUE', $names);
        $this->assertContains('BOOLEAN_FALSE', $names);
        $this->assertContains('INTEGER_ZERO', $names);
        $this->assertContains('INTEGER_ONE', $names);
        $this->assertContains('INTEGER_TWO', $names);
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
        $this->assertCount(2, Enum::names('FLOAT'));
        $this->assertCount(2, Enum::names('float', false));
        $this->assertCount(2, Enum::names('STRING'));
        $this->assertCount(2, Enum::names('string', false));
        $this->assertCount(2, Enum::names('ARRAY'));
        $this->assertCount(2, Enum::names('array', false));
        $this->assertCount(1, Enum::names('NULL'));
        $this->assertCount(1, Enum::names('null', false));
    }

    public function testEnumKeys()
    {
        $keys = ArrayEnum::getKeys();
        $this->assertContains("This doesn't exist", $keys); // https://github.com/sebastianbergmann/phpunit/issues/2111
        $this->assertContains(TRUE, $keys);
        $this->assertContains(FALSE, $keys);
        $this->assertContains(0, $keys);
        $this->assertContains(1, $keys);
        $this->assertContains(-2, $keys);
        $this->assertContains(0.0, $keys); // The results are not credible.
        $this->assertContains(1.0, $keys); // The results are not credible.
        $this->assertContains('', $keys);
        $this->assertContains('1', $keys);
        $this->assertContains([], $keys);
        $this->assertContains([1], $keys);
        $this->assertContains(NULL, $keys);
        $this->assertCount(2, ArrayEnum::getKeys('BOOLEAN'));
        $this->assertCount(2, ArrayEnum::getKeys('boolean', false));
        $this->assertCount(3, ArrayEnum::getKeys('INTEGER'));
        $this->assertCount(3, ArrayEnum::getKeys('integer', false));
        $this->assertCount(2, ArrayEnum::getKeys('FLOAT'));
        $this->assertCount(2, ArrayEnum::getKeys('float', false));
        $this->assertCount(2, ArrayEnum::getKeys('STRING'));
        $this->assertCount(2, ArrayEnum::getKeys('string', false));
        $this->assertCount(2, ArrayEnum::getKeys('ARRAY'));
        $this->assertCount(2, ArrayEnum::getKeys('array', false));
        $this->assertCount(1, ArrayEnum::getKeys('NULL'));
        $this->assertCount(1, ArrayEnum::getKeys('null', false));
    }

    public function testEnumValues()
    {
        $values = ArrayEnum::getValues();
        $this->assertContains('true', $values);
        $this->assertContains('false', $values);
        $this->assertContains('zero', $values);
        $this->assertContains('one', $values);
        $this->assertContains('two', $values);
        $this->assertContains('empty', $values);
        $this->assertContains('null', $values);
        $this->assertCount(2, ArrayEnum::getValues('BOOLEAN'));
        $this->assertCount(2, ArrayEnum::getValues('boolean', false));
        $this->assertCount(3, ArrayEnum::getValues('INTEGER'));
        $this->assertCount(3, ArrayEnum::getValues('integer', false));
        $this->assertCount(2, ArrayEnum::getValues('FLOAT'));
        $this->assertCount(2, ArrayEnum::getValues('float', false));
        $this->assertCount(2, ArrayEnum::getValues('STRING'));
        $this->assertCount(2, ArrayEnum::getValues('string', false));
        $this->assertCount(2, ArrayEnum::getValues('ARRAY'));
        $this->assertCount(2, ArrayEnum::getValues('array', false));
        $this->assertCount(1, ArrayEnum::getValues('NULL'));
        $this->assertCount(1, ArrayEnum::getValues('null', false));
    }

    public function testEnumEnums()
    {
        $this->assertCount(2, ArrayEnum::enums('BOOLEAN'));
        $this->assertCount(2, ArrayEnum::enums('boolean', false));
        $this->assertCount(3, ArrayEnum::enums('INTEGER'));
        $this->assertCount(3, ArrayEnum::enums('integer', false));
        $this->assertCount(2, ArrayEnum::enums('FLOAT'));
        $this->assertCount(2, ArrayEnum::enums('float', false));
        $this->assertCount(2, ArrayEnum::enums('STRING'));
        $this->assertCount(2, ArrayEnum::enums('string', false));
        $this->assertCount(2, ArrayEnum::enums('ARRAY'));
        $this->assertCount(2, ArrayEnum::enums('array', false));
        $this->assertCount(1, ArrayEnum::enums('NULL'));
        $this->assertCount(1, ArrayEnum::enums('null', false));
    }

    public function testEnumHasName()
    {
        $this->assertTrue(ArrayEnum::hasName('BOOLEAN_TRUE'));
        $this->assertTrue(ArrayEnum::hasName('BOOLEAN_FALSE'));
        $this->assertTrue(ArrayEnum::hasName('INTEGER_ZERO'));
        $this->assertTrue(ArrayEnum::hasName('INTEGER_ONE'));
        $this->assertTrue(ArrayEnum::hasName('INTEGER_TWO'));
        $this->assertTrue(ArrayEnum::hasName('FLOAT_ZERO'));
        $this->assertTrue(ArrayEnum::hasName('FLOAT_ONE'));
        $this->assertTrue(ArrayEnum::hasName('STRING_EMPTY'));
        $this->assertTrue(ArrayEnum::hasName('STRING_ONE'));
        $this->assertTrue(ArrayEnum::hasName('ARRAY_EMPTY'));
        $this->assertTrue(ArrayEnum::hasName('ARRAY_ONE'));
        $this->assertTrue(ArrayEnum::hasName('NULL_NULL'));
    }

    public function testEnumHasKey()
    {
        $this->assertTrue(ArrayEnum::hasKey(TRUE));
        $this->assertTrue(ArrayEnum::hasKey(FALSE));
        $this->assertTrue(ArrayEnum::hasKey(0));
        $this->assertTrue(ArrayEnum::hasKey(1));
        $this->assertTrue(ArrayEnum::hasKey(-2));
        $this->assertTrue(ArrayEnum::hasKey(0.0)); // The results are not credible.
        $this->assertTrue(ArrayEnum::hasKey(1.0)); // The results are not credible.
        $this->assertTrue(ArrayEnum::hasKey(''));
        $this->assertTrue(ArrayEnum::hasKey('1'));
        $this->assertTrue(ArrayEnum::hasKey([]));
        $this->assertTrue(ArrayEnum::hasKey([1]));
        $this->assertTrue(ArrayEnum::hasKey(NULL));
    }

    public function testEnumHasValue()
    {
        $this->assertTrue(ArrayEnum::hasValue('true'));
        $this->assertTrue(ArrayEnum::hasValue('false'));
        $this->assertTrue(ArrayEnum::hasValue('zero', 'INTEGER'));
        $this->assertTrue(ArrayEnum::hasValue('one', 'INTEGER'));
        $this->assertTrue(ArrayEnum::hasValue('two', 'INTEGER'));
        $this->assertTrue(ArrayEnum::hasValue('zero', 'FLOAT'));
        $this->assertTrue(ArrayEnum::hasValue('one', 'FLOAT'));
        $this->assertTrue(ArrayEnum::hasValue('empty', 'STRING'));
        $this->assertTrue(ArrayEnum::hasValue('one', 'STRING'));
        $this->assertTrue(ArrayEnum::hasValue('empty', 'ARRAY'));
        $this->assertTrue(ArrayEnum::hasValue('one', 'ARRAY'));
        $this->assertTrue(ArrayEnum::hasValue('null'));
    }

    public function testEnumByName()
    {
        $this->assertTrue(ArrayEnum::byName('BOOLEAN_TRUE')->equals(ArrayEnum::BOOLEAN_TRUE()));
        $this->assertTrue(ArrayEnum::byName('BOOLEAN_FALSE')->equals(ArrayEnum::BOOLEAN_FALSE()));
        $this->assertTrue(ArrayEnum::byName('INTEGER_ZERO')->equals(ArrayEnum::INTEGER_ZERO()));
        $this->assertTrue(ArrayEnum::byName('INTEGER_ONE')->equals(ArrayEnum::INTEGER_ONE()));
        $this->assertTrue(ArrayEnum::byName('INTEGER_TWO')->equals(ArrayEnum::INTEGER_TWO()));
        $this->assertTrue(ArrayEnum::byName('FLOAT_ZERO')->equals(ArrayEnum::FLOAT_ZERO()));
        $this->assertTrue(ArrayEnum::byName('FLOAT_ONE')->equals(ArrayEnum::FLOAT_ONE()));
        $this->assertTrue(ArrayEnum::byName('STRING_EMPTY')->equals(ArrayEnum::STRING_EMPTY()));
        $this->assertTrue(ArrayEnum::byName('STRING_ONE')->equals(ArrayEnum::STRING_ONE()));
        $this->assertTrue(ArrayEnum::byName('ARRAY_EMPTY')->equals(ArrayEnum::ARRAY_EMPTY()));
        $this->assertTrue(ArrayEnum::byName('ARRAY_ONE')->equals(ArrayEnum::ARRAY_ONE()));
        $this->assertTrue(ArrayEnum::byName('NULL_NULL')->equals(ArrayEnum::NULL_NULL()));
    }

    public function testEnumByKey()
    {
        $this->assertTrue(ArrayEnum::byKey(TRUE)->equals(ArrayEnum::BOOLEAN_TRUE()));
        $this->assertTrue(ArrayEnum::byKey(FALSE)->equals(ArrayEnum::BOOLEAN_FALSE()));
        $this->assertTrue(ArrayEnum::byKey(0)->equals(ArrayEnum::INTEGER_ZERO()));
        $this->assertTrue(ArrayEnum::byKey(1)->equals(ArrayEnum::INTEGER_ONE()));
        $this->assertTrue(ArrayEnum::byKey(-2)->equals(ArrayEnum::INTEGER_TWO()));
        $this->assertTrue(ArrayEnum::byKey(0.0)->equals(ArrayEnum::FLOAT_ZERO())); // The results are not credible.
        $this->assertTrue(ArrayEnum::byKey(1.0)->equals(ArrayEnum::FLOAT_ONE())); // The results are not credible.
        $this->assertTrue(ArrayEnum::byKey('')->equals(ArrayEnum::STRING_EMPTY()));
        $this->assertTrue(ArrayEnum::byKey('1')->equals(ArrayEnum::STRING_ONE()));
        $this->assertTrue(ArrayEnum::byKey([])->equals(ArrayEnum::ARRAY_EMPTY()));
        $this->assertTrue(ArrayEnum::byKey([1])->equals(ArrayEnum::ARRAY_ONE()));
        $this->assertTrue(ArrayEnum::byKey(NULL)->equals(ArrayEnum::NULL_NULL()));
    }

    public function testEnumByValue()
    {
        $this->assertTrue(ArrayEnum::byValue('true')->equals(ArrayEnum::BOOLEAN_TRUE()));
        $this->assertTrue(ArrayEnum::byValue('false')->equals(ArrayEnum::BOOLEAN_FALSE()));
        $this->assertTrue(ArrayEnum::byValue('zero', 'INTEGER')->equals(ArrayEnum::INTEGER_ZERO()));
        $this->assertTrue(ArrayEnum::byValue('one', 'INTEGER')->equals(ArrayEnum::INTEGER_ONE()));
        $this->assertTrue(ArrayEnum::byValue('two', 'INTEGER')->equals(ArrayEnum::INTEGER_TWO()));
        $this->assertTrue(ArrayEnum::byValue('zero', 'FLOAT')->equals(ArrayEnum::FLOAT_ZERO()));
        $this->assertTrue(ArrayEnum::byValue('one', 'FLOAT')->equals(ArrayEnum::FLOAT_ONE()));
        $this->assertTrue(ArrayEnum::byValue('empty', 'STRING')->equals(ArrayEnum::STRING_EMPTY()));
        $this->assertTrue(ArrayEnum::byValue('one', 'STRING')->equals(ArrayEnum::STRING_ONE()));
        $this->assertTrue(ArrayEnum::byValue('empty', 'ARRAY')->equals(ArrayEnum::ARRAY_EMPTY()));
        $this->assertTrue(ArrayEnum::byValue('one', 'ARRAY')->equals(ArrayEnum::ARRAY_ONE()));
        $this->assertTrue(ArrayEnum::byValue('null')->equals(ArrayEnum::NULL_NULL()));
    }

    public function testEnumCount()
    {
        $this->assertCount(ArrayEnum::count(), ArrayEnum::getKeys());
        $this->assertCount(ArrayEnum::count(), ArrayEnum::getValues());
        $this->assertCount(ArrayEnum::count(), ArrayEnum::getEnums());
        $this->assertCount(ArrayEnum::count('BOOLEAN'), ArrayEnum::names('BOOLEAN'));
        $this->assertCount(ArrayEnum::count('boolean', false), ArrayEnum::names('boolean', false));
        $this->assertCount(ArrayEnum::count('INTEGER'), ArrayEnum::names('INTEGER'));
        $this->assertCount(ArrayEnum::count('integer', false), ArrayEnum::names('integer', false));
        $this->assertCount(ArrayEnum::count('FLOAT'), ArrayEnum::names('FLOAT'));
        $this->assertCount(ArrayEnum::count('float', false), ArrayEnum::names('float', false));
        $this->assertCount(ArrayEnum::count('STRING'), ArrayEnum::names('STRING'));
        $this->assertCount(ArrayEnum::count('string', false), ArrayEnum::names('string', false));
        $this->assertCount(ArrayEnum::count('ARRAY'), ArrayEnum::names('ARRAY'));
        $this->assertCount(ArrayEnum::count('array', false), ArrayEnum::names('array', false));
        $this->assertCount(ArrayEnum::count('NULL'), ArrayEnum::names('NULL'));
        $this->assertCount(ArrayEnum::count('null', false), ArrayEnum::names('null', false));
    }

}