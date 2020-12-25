<?php

namespace PhpEnum\Tests;

use PhpEnum\Exceptions\PropertyNotFoundException;
use PHPUnit\Framework\TestCase;

class ArrayEnumTest extends TestCase
{
    public function testEnumName()
    {
        $this->assertEquals('BOOLEAN_TRUE', ArrayEnum::BOOLEAN_TRUE()->name());
        $this->assertEquals('BOOLEAN_FALSE', ArrayEnum::BOOLEAN_FALSE()->name());
        $this->assertEquals('INTEGER_ZERO', ArrayEnum::INTEGER_ZERO()->name());
        $this->assertEquals('INTEGER_ONE', ArrayEnum::INTEGER_ONE()->name());
        $this->assertEquals('INTEGER_TWO', ArrayEnum::INTEGER_TWO()->name());
        $this->assertEquals('FLOAT_ZERO', ArrayEnum::FLOAT_ZERO()->name());
        $this->assertEquals('FLOAT_ONE', ArrayEnum::FLOAT_ONE()->name());
        $this->assertEquals('STRING_EMPTY', ArrayEnum::STRING_EMPTY()->name());
        $this->assertEquals('STRING_ONE', ArrayEnum::STRING_ONE()->name());
        $this->assertEquals('ARRAY_EMPTY', ArrayEnum::ARRAY_EMPTY()->name());
        $this->assertEquals('ARRAY_ONE', ArrayEnum::ARRAY_ONE()->name());
        $this->assertEquals('NULL_NULL', ArrayEnum::NULL_NULL()->name());
    }

    public function testEnumKey()
    {
        $this->assertEquals(TRUE, ArrayEnum::BOOLEAN_TRUE()->getKey());
        $this->assertEquals(FALSE, ArrayEnum::BOOLEAN_FALSE()->getKey());
        $this->assertEquals(0, ArrayEnum::INTEGER_ZERO()->getKey());
        $this->assertEquals(1, ArrayEnum::INTEGER_ONE()->getKey());
        $this->assertEquals(-2, ArrayEnum::INTEGER_TWO()->getKey());
        $this->assertEquals(0.0, ArrayEnum::FLOAT_ZERO()->getKey());
        $this->assertEquals(1.0, ArrayEnum::FLOAT_ONE()->getKey());
        $this->assertEquals('', ArrayEnum::STRING_EMPTY()->getKey());
        $this->assertEquals('1', ArrayEnum::STRING_ONE()->getKey());
        $this->assertEquals([], ArrayEnum::ARRAY_EMPTY()->getKey());
        $this->assertEquals([1], ArrayEnum::ARRAY_ONE()->getKey());
        $this->assertEquals(NULL, ArrayEnum::NULL_NULL()->getKey());
    }

    public function testEnumValue()
    {
        $this->assertEquals('true', ArrayEnum::BOOLEAN_TRUE()->getValue());
        $this->assertEquals('false', ArrayEnum::BOOLEAN_FALSE()->getValue());
        $this->assertEquals('zero', ArrayEnum::INTEGER_ZERO()->getValue());
        $this->assertEquals('one', ArrayEnum::INTEGER_ONE()->getValue());
        $this->assertEquals('two', ArrayEnum::INTEGER_TWO()->getValue());
        $this->assertEquals('zero', ArrayEnum::FLOAT_ZERO()->getValue());
        $this->assertEquals('one', ArrayEnum::FLOAT_ONE()->getValue());
        $this->assertEquals('empty', ArrayEnum::STRING_EMPTY()->getValue());
        $this->assertEquals('one', ArrayEnum::STRING_ONE()->getValue());
        $this->assertEquals('empty', ArrayEnum::ARRAY_EMPTY()->getValue());
        $this->assertEquals('one', ArrayEnum::ARRAY_ONE()->getValue());
        $this->assertEquals('null', ArrayEnum::NULL_NULL()->getValue());
    }

    public function testEnumNameEquals()
    {
        $this->assertTrue(ArrayEnum::BOOLEAN_TRUE()->enumNameEquals('BOOLEAN_TRUE'));
        $this->assertTrue(ArrayEnum::BOOLEAN_FALSE()->enumNameEquals('BOOLEAN_FALSE'));
        $this->assertTrue(ArrayEnum::INTEGER_ZERO()->enumNameEquals('INTEGER_ZERO'));
        $this->assertTrue(ArrayEnum::INTEGER_ONE()->enumNameEquals('INTEGER_ONE'));
        $this->assertTrue(ArrayEnum::INTEGER_TWO()->enumNameEquals('INTEGER_TWO'));
        $this->assertTrue(ArrayEnum::FLOAT_ZERO()->enumNameEquals('FLOAT_ZERO'));
        $this->assertTrue(ArrayEnum::FLOAT_ONE()->enumNameEquals('FLOAT_ONE'));
        $this->assertTrue(ArrayEnum::STRING_EMPTY()->enumNameEquals('STRING_EMPTY'));
        $this->assertTrue(ArrayEnum::STRING_ONE()->enumNameEquals('STRING_ONE'));
        $this->assertTrue(ArrayEnum::ARRAY_EMPTY()->enumNameEquals('ARRAY_EMPTY'));
        $this->assertTrue(ArrayEnum::ARRAY_ONE()->enumNameEquals('ARRAY_ONE'));
        $this->assertTrue(ArrayEnum::NULL_NULL()->enumNameEquals('NULL_NULL'));
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
        $this->assertCount(2, ArrayEnum::names('BOOLEAN'));
        $this->assertCount(3, ArrayEnum::names('INTEGER'));
        $this->assertCount(2, ArrayEnum::names('FLOAT'));
        $this->assertCount(2, ArrayEnum::names('STRING'));
        $this->assertCount(2, ArrayEnum::names('ARRAY'));
        $this->assertCount(1, ArrayEnum::names('NULL'));
    }

    /**
     * @throws PropertyNotFoundException
     */
    public function testEnumKeys()
    {
        $this->assertCount(2, ArrayEnum::getProperties('key', 'BOOLEAN'));
        $this->assertCount(3, ArrayEnum::getProperties('key', 'INTEGER'));
        $this->assertCount(2, ArrayEnum::getProperties('key', 'FLOAT'));
        $this->assertCount(2, ArrayEnum::getProperties('key', 'STRING'));
        $this->assertCount(2, ArrayEnum::getProperties('key', 'ARRAY'));
        $this->assertCount(1, ArrayEnum::getProperties('key', 'NULL'));
    }

    /**
     * @throws PropertyNotFoundException
     */
    public function testEnumValues()
    {
        $this->assertCount(2, ArrayEnum::getProperties('value', 'BOOLEAN'));
        $this->assertCount(3, ArrayEnum::getProperties('value', 'INTEGER'));
        $this->assertCount(2, ArrayEnum::getProperties('value', 'FLOAT'));
        $this->assertCount(2, ArrayEnum::getProperties('value', 'STRING'));
        $this->assertCount(2, ArrayEnum::getProperties('value', 'ARRAY'));
        $this->assertCount(1, ArrayEnum::getProperties('value', 'NULL'));
    }

    public function testEnumEnums()
    {
        $this->assertCount(2, ArrayEnum::enums('BOOLEAN'));
        $this->assertCount(3, ArrayEnum::enums('INTEGER'));
        $this->assertCount(2, ArrayEnum::enums('FLOAT'));
        $this->assertCount(2, ArrayEnum::enums('STRING'));
        $this->assertCount(2, ArrayEnum::enums('ARRAY'));
        $this->assertCount(1, ArrayEnum::enums('NULL'));
    }

    public function testEnumContainsName()
    {
        $this->assertEquals(1, ArrayEnum::containsEnumName('BOOLEAN_TRUE'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('BOOLEAN_FALSE'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('INTEGER_ZERO'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('INTEGER_ONE'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('INTEGER_TWO'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('FLOAT_ZERO'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('FLOAT_ONE'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('STRING_EMPTY'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('STRING_ONE'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('ARRAY_EMPTY'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('ARRAY_ONE'));
        $this->assertEquals(1, ArrayEnum::containsEnumName('NULL_NULL'));
    }

    public function testEnumContainsKey()
    {
        $this->assertEquals(1, ArrayEnum::containsKey(TRUE));
        $this->assertEquals(1, ArrayEnum::containsKey(FALSE));
        $this->assertEquals(1, ArrayEnum::containsKey(0));
        $this->assertEquals(1, ArrayEnum::containsKey(1));
        $this->assertEquals(1, ArrayEnum::containsKey(-2));
        $this->assertEquals(1, ArrayEnum::containsKey(0.0));
        $this->assertEquals(1, ArrayEnum::containsKey(1.0));
        $this->assertEquals(1, ArrayEnum::containsKey(''));
        $this->assertEquals(1, ArrayEnum::containsKey('1'));
        $this->assertEquals(1, ArrayEnum::containsKey([]));
        $this->assertEquals(1, ArrayEnum::containsKey([1]));
        $this->assertEquals(1, ArrayEnum::containsKey(NULL));
    }

    public function testEnumContainsValue()
    {
        $this->assertEquals(1, ArrayEnum::containsValue('true'));
        $this->assertEquals(1, ArrayEnum::containsValue('false'));
        $this->assertEquals(1, ArrayEnum::containsValue('zero', 'INTEGER'));
        $this->assertEquals(1, ArrayEnum::containsValue('one', 'INTEGER'));
        $this->assertEquals(1, ArrayEnum::containsValue('two', 'INTEGER'));
        $this->assertEquals(1, ArrayEnum::containsValue('zero', 'FLOAT'));
        $this->assertEquals(1, ArrayEnum::containsValue('one', 'FLOAT'));
        $this->assertEquals(1, ArrayEnum::containsValue('empty', 'STRING'));
        $this->assertEquals(1, ArrayEnum::containsValue('one', 'STRING'));
        $this->assertEquals(1, ArrayEnum::containsValue('empty', 'ARRAY'));
        $this->assertEquals(1, ArrayEnum::containsValue('one', 'ARRAY'));
        $this->assertEquals(1, ArrayEnum::containsValue('null'));
    }

    public function testEnumOfName()
    {
        $this->assertTrue(ArrayEnum::ofEnumName('BOOLEAN_TRUE')->equals(ArrayEnum::BOOLEAN_TRUE()));
        $this->assertTrue(ArrayEnum::ofEnumName('BOOLEAN_FALSE')->equals(ArrayEnum::BOOLEAN_FALSE()));
        $this->assertTrue(ArrayEnum::ofEnumName('INTEGER_ZERO')->equals(ArrayEnum::INTEGER_ZERO()));
        $this->assertTrue(ArrayEnum::ofEnumName('INTEGER_ONE')->equals(ArrayEnum::INTEGER_ONE()));
        $this->assertTrue(ArrayEnum::ofEnumName('INTEGER_TWO')->equals(ArrayEnum::INTEGER_TWO()));
        $this->assertTrue(ArrayEnum::ofEnumName('FLOAT_ZERO')->equals(ArrayEnum::FLOAT_ZERO()));
        $this->assertTrue(ArrayEnum::ofEnumName('FLOAT_ONE')->equals(ArrayEnum::FLOAT_ONE()));
        $this->assertTrue(ArrayEnum::ofEnumName('STRING_EMPTY')->equals(ArrayEnum::STRING_EMPTY()));
        $this->assertTrue(ArrayEnum::ofEnumName('STRING_ONE')->equals(ArrayEnum::STRING_ONE()));
        $this->assertTrue(ArrayEnum::ofEnumName('ARRAY_EMPTY')->equals(ArrayEnum::ARRAY_EMPTY()));
        $this->assertTrue(ArrayEnum::ofEnumName('ARRAY_ONE')->equals(ArrayEnum::ARRAY_ONE()));
        $this->assertTrue(ArrayEnum::ofEnumName('NULL_NULL')->equals(ArrayEnum::NULL_NULL()));
    }

    public function testEnumOfKey()
    {
        $this->assertTrue(ArrayEnum::ofKey(TRUE)->equals(ArrayEnum::BOOLEAN_TRUE()));
        $this->assertTrue(ArrayEnum::ofKey(FALSE)->equals(ArrayEnum::BOOLEAN_FALSE()));
        $this->assertTrue(ArrayEnum::ofKey(0)->equals(ArrayEnum::INTEGER_ZERO()));
        $this->assertTrue(ArrayEnum::ofKey(1)->equals(ArrayEnum::INTEGER_ONE()));
        $this->assertTrue(ArrayEnum::ofKey(-2)->equals(ArrayEnum::INTEGER_TWO()));
        $this->assertTrue(ArrayEnum::ofKey(0.0)->equals(ArrayEnum::FLOAT_ZERO()));
        $this->assertTrue(ArrayEnum::ofKey(1.0)->equals(ArrayEnum::FLOAT_ONE()));
        $this->assertTrue(ArrayEnum::ofKey('')->equals(ArrayEnum::STRING_EMPTY()));
        $this->assertTrue(ArrayEnum::ofKey('1')->equals(ArrayEnum::STRING_ONE()));
        $this->assertTrue(ArrayEnum::ofKey([])->equals(ArrayEnum::ARRAY_EMPTY()));
        $this->assertTrue(ArrayEnum::ofKey([1])->equals(ArrayEnum::ARRAY_ONE()));
        $this->assertTrue(ArrayEnum::ofKey(NULL)->equals(ArrayEnum::NULL_NULL()));
    }

    public function testEnumOfValue()
    {
        $this->assertTrue(ArrayEnum::ofValue('true')->equals(ArrayEnum::BOOLEAN_TRUE()));
        $this->assertTrue(ArrayEnum::ofValue('false')->equals(ArrayEnum::BOOLEAN_FALSE()));
        $this->assertTrue(ArrayEnum::ofValue('zero', 'INTEGER')->equals(ArrayEnum::INTEGER_ZERO()));
        $this->assertTrue(ArrayEnum::ofValue('one', 'INTEGER')->equals(ArrayEnum::INTEGER_ONE()));
        $this->assertTrue(ArrayEnum::ofValue('two', 'INTEGER')->equals(ArrayEnum::INTEGER_TWO()));
        $this->assertTrue(ArrayEnum::ofValue('zero', 'FLOAT')->equals(ArrayEnum::FLOAT_ZERO()));
        $this->assertTrue(ArrayEnum::ofValue('one', 'FLOAT')->equals(ArrayEnum::FLOAT_ONE()));
        $this->assertTrue(ArrayEnum::ofValue('empty', 'STRING')->equals(ArrayEnum::STRING_EMPTY()));
        $this->assertTrue(ArrayEnum::ofValue('one', 'STRING')->equals(ArrayEnum::STRING_ONE()));
        $this->assertTrue(ArrayEnum::ofValue('empty', 'ARRAY')->equals(ArrayEnum::ARRAY_EMPTY()));
        $this->assertTrue(ArrayEnum::ofValue('one', 'ARRAY')->equals(ArrayEnum::ARRAY_ONE()));
        $this->assertTrue(ArrayEnum::ofValue('null')->equals(ArrayEnum::NULL_NULL()));
    }

}