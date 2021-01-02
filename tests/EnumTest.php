<?php

namespace PhpEnum\Tests;

use PhpEnum\Exceptions\IllegalArgumentException;
use PhpEnum\Exceptions\InstantiationException;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnumType()
    {
        $this->assertInstanceOf(Enum::class, Enum::BOOLEAN_TRUE());
        $this->assertInstanceOf(Enum::class, Enum::BOOLEAN_FALSE());
        $this->assertInstanceOf(Enum::class, Enum::INTEGER_ZERO());
        $this->assertInstanceOf(Enum::class, Enum::INTEGER_ONE());
        $this->assertInstanceOf(Enum::class, Enum::INTEGER_MINUS_TWO());
        $this->assertInstanceOf(Enum::class, Enum::INTEGER_THREE());
        $this->assertInstanceOf(Enum::class, Enum::FLOAT_ZERO());
        $this->assertInstanceOf(Enum::class, Enum::FLOAT_MINUS_POINT_ONE());
        $this->assertInstanceOf(Enum::class, Enum::FLOAT_POINT_ONE());
        $this->assertInstanceOf(Enum::class, Enum::FLOAT_ONE());
        $this->assertInstanceOf(Enum::class, Enum::STRING_EMPTY());
        $this->assertInstanceOf(Enum::class, Enum::STRING_INTEGER_ONE());
        $this->assertInstanceOf(Enum::class, Enum::STRING_ONE());
        $this->assertInstanceOf(Enum::class, Enum::STRING_EOF());
        $this->assertInstanceOf(Enum::class, Enum::ARRAY_EMPTY());
        $this->assertInstanceOf(Enum::class, Enum::ARRAY_ONE());
        $this->assertInstanceOf(Enum::class, Enum::ARRAY_FLOAT_TWO());
        $this->assertInstanceOf(Enum::class, Enum::ARRAY_STRING());
        $this->assertInstanceOf(Enum::class, Enum::NULL_NULL());

        $this->assertEquals('string', gettype(Enum::BOOLEAN_TRUE()->name()));
        $this->assertEquals('string', gettype(Enum::BOOLEAN_FALSE()->name()));
        $this->assertEquals('string', gettype(Enum::INTEGER_ZERO()->name()));
        $this->assertEquals('string', gettype(Enum::INTEGER_ONE()->name()));
        $this->assertEquals('string', gettype(Enum::INTEGER_MINUS_TWO()->name()));
        $this->assertEquals('string', gettype(Enum::INTEGER_THREE()->name()));
        $this->assertEquals('string', gettype(Enum::FLOAT_ZERO()->name()));
        $this->assertEquals('string', gettype(Enum::FLOAT_MINUS_POINT_ONE()->name()));
        $this->assertEquals('string', gettype(Enum::FLOAT_POINT_ONE()->name()));
        $this->assertEquals('string', gettype(Enum::FLOAT_ONE()->name()));
        $this->assertEquals('string', gettype(Enum::STRING_EMPTY()->name()));
        $this->assertEquals('string', gettype(Enum::STRING_INTEGER_ONE()->name()));
        $this->assertEquals('string', gettype(Enum::STRING_ONE()->name()));
        $this->assertEquals('string', gettype(Enum::STRING_EOF()->name()));
        $this->assertEquals('string', gettype(Enum::ARRAY_EMPTY()->name()));
        $this->assertEquals('string', gettype(Enum::ARRAY_ONE()->name()));
        $this->assertEquals('string', gettype(Enum::ARRAY_FLOAT_TWO()->name()));
        $this->assertEquals('string', gettype(Enum::ARRAY_STRING()->name()));
        $this->assertEquals('string', gettype(Enum::NULL_NULL()->name()));

        $this->assertEquals('boolean', gettype(Enum::BOOLEAN_TRUE()->getValue()));
        $this->assertEquals('boolean', gettype(Enum::BOOLEAN_FALSE()->getValue()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_ZERO()->getValue()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_ONE()->getValue()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_MINUS_TWO()->getValue()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_THREE()->getValue()));
        $this->assertEquals('double', gettype(Enum::FLOAT_ZERO()->getValue()));
        $this->assertEquals('double', gettype(Enum::FLOAT_MINUS_POINT_ONE()->getValue()));
        $this->assertEquals('double', gettype(Enum::FLOAT_POINT_ONE()->getValue()));
        $this->assertEquals('double', gettype(Enum::FLOAT_ONE()->getValue()));
        $this->assertEquals('string', gettype(Enum::STRING_EMPTY()->getValue()));
        $this->assertEquals('string', gettype(Enum::STRING_INTEGER_ONE()->getValue()));
        $this->assertEquals('string', gettype(Enum::STRING_ONE()->getValue()));
        $this->assertEquals('string', gettype(Enum::STRING_EOF()->getValue()));
        $this->assertEquals('array', gettype(Enum::ARRAY_EMPTY()->getValue()));
        $this->assertEquals('array', gettype(Enum::ARRAY_ONE()->getValue()));
        $this->assertEquals('array', gettype(Enum::ARRAY_FLOAT_TWO()->getValue()));
        $this->assertEquals('array', gettype(Enum::ARRAY_STRING()->getValue()));
        $this->assertEquals('NULL', gettype(Enum::NULL_NULL()->getValue()));
    }

    public function testEnumName()
    {
        $this->assertEquals('BOOLEAN_TRUE', Enum::BOOLEAN_TRUE()->name());
        $this->assertEquals('BOOLEAN_FALSE', Enum::BOOLEAN_FALSE()->name());
        $this->assertEquals('INTEGER_ZERO', Enum::INTEGER_ZERO()->name());
        $this->assertEquals('INTEGER_ONE', Enum::INTEGER_ONE()->name());
        $this->assertEquals('INTEGER_MINUS_TWO', Enum::INTEGER_MINUS_TWO()->name());
        $this->assertEquals('INTEGER_THREE', Enum::INTEGER_THREE()->name());
        $this->assertEquals('FLOAT_ZERO', Enum::FLOAT_ZERO()->name());
        $this->assertEquals('FLOAT_MINUS_POINT_ONE', Enum::FLOAT_MINUS_POINT_ONE()->name());
        $this->assertEquals('FLOAT_POINT_ONE', Enum::FLOAT_POINT_ONE()->name());
        $this->assertEquals('FLOAT_ONE', Enum::FLOAT_ONE()->name());
        $this->assertEquals('STRING_EMPTY', Enum::STRING_EMPTY()->name());
        $this->assertEquals('STRING_INTEGER_ONE', Enum::STRING_INTEGER_ONE()->name());
        $this->assertEquals('STRING_ONE', Enum::STRING_ONE()->name());
        $this->assertEquals('STRING_EOF', Enum::STRING_EOF()->name());
        $this->assertEquals('ARRAY_EMPTY', Enum::ARRAY_EMPTY()->name());
        $this->assertEquals('ARRAY_ONE', Enum::ARRAY_ONE()->name());
        $this->assertEquals('ARRAY_FLOAT_TWO', Enum::ARRAY_FLOAT_TWO()->name());
        $this->assertEquals('ARRAY_STRING', Enum::ARRAY_STRING()->name());
        $this->assertEquals('NULL_NULL', Enum::NULL_NULL()->name());
    }

    public function testEnumOrdinal()
    {
        $this->assertEquals(0, Enum::BOOLEAN_TRUE()->ordinal());
        $this->assertEquals(1, Enum::BOOLEAN_FALSE()->ordinal());
        $this->assertEquals(2, Enum::INTEGER_ZERO()->ordinal());
        $this->assertEquals(3, Enum::INTEGER_ONE()->ordinal());
        $this->assertEquals(4, Enum::INTEGER_MINUS_TWO()->ordinal());
        $this->assertEquals(5, Enum::INTEGER_THREE()->ordinal());
        $this->assertEquals(6, Enum::FLOAT_ZERO()->ordinal());
        $this->assertEquals(7, Enum::FLOAT_MINUS_POINT_ONE()->ordinal());
        $this->assertEquals(8, Enum::FLOAT_POINT_ONE()->ordinal());
        $this->assertEquals(9, Enum::FLOAT_ONE()->ordinal());
        $this->assertEquals(10, Enum::STRING_EMPTY()->ordinal());
        $this->assertEquals(11, Enum::STRING_INTEGER_ONE()->ordinal());
        $this->assertEquals(12, Enum::STRING_ONE()->ordinal());
        $this->assertEquals(13, Enum::STRING_EOF()->ordinal());
        $this->assertEquals(14, Enum::ARRAY_EMPTY()->ordinal());
        $this->assertEquals(15, Enum::ARRAY_ONE()->ordinal());
        $this->assertEquals(16, Enum::ARRAY_FLOAT_TWO()->ordinal());
        $this->assertEquals(17, Enum::ARRAY_STRING()->ordinal());
        $this->assertEquals(18, Enum::NULL_NULL()->ordinal());
    }

    /**
     * @throws IllegalArgumentException
     * @throws InstantiationException
     */
    public function testEnumValues()
    {
        $enums = Enum::values();
        $this->assertTrue(Enum::BOOLEAN_TRUE()->equals($enums['BOOLEAN_TRUE']));
        $this->assertTrue(Enum::BOOLEAN_FALSE()->equals($enums['BOOLEAN_FALSE']));
        $this->assertTrue(Enum::INTEGER_ZERO()->equals($enums['INTEGER_ZERO']));
        $this->assertTrue(Enum::INTEGER_ONE()->equals($enums['INTEGER_ONE']));
        $this->assertTrue(Enum::INTEGER_MINUS_TWO()->equals($enums['INTEGER_MINUS_TWO']));
        $this->assertTrue(Enum::INTEGER_THREE()->equals($enums['INTEGER_THREE']));
        $this->assertTrue(Enum::FLOAT_ZERO()->equals($enums['FLOAT_ZERO']));
        $this->assertTrue(Enum::FLOAT_MINUS_POINT_ONE()->equals($enums['FLOAT_MINUS_POINT_ONE']));
        $this->assertTrue(Enum::FLOAT_POINT_ONE()->equals($enums['FLOAT_POINT_ONE']));
        $this->assertTrue(Enum::FLOAT_ONE()->equals($enums['FLOAT_ONE']));
        $this->assertTrue(Enum::STRING_EMPTY()->equals($enums['STRING_EMPTY']));
        $this->assertTrue(Enum::STRING_INTEGER_ONE()->equals($enums['STRING_INTEGER_ONE']));
        $this->assertTrue(Enum::STRING_ONE()->equals($enums['STRING_ONE']));
        $this->assertTrue(Enum::STRING_EOF()->equals($enums['STRING_EOF']));
        $this->assertTrue(Enum::ARRAY_EMPTY()->equals($enums['ARRAY_EMPTY']));
        $this->assertTrue(Enum::ARRAY_ONE()->equals($enums['ARRAY_ONE']));
        $this->assertTrue(Enum::ARRAY_FLOAT_TWO()->equals($enums['ARRAY_FLOAT_TWO']));
        $this->assertTrue(Enum::ARRAY_STRING()->equals($enums['ARRAY_STRING']));
        $this->assertTrue(Enum::NULL_NULL()->equals($enums['NULL_NULL']));
    }

    /**
     * @throws IllegalArgumentException
     * @throws InstantiationException
     */
    public function testEnumValueOf()
    {
        $this->assertEquals(Enum::BOOLEAN_TRUE(), Enum::valueOf('BOOLEAN_TRUE'));
        $this->assertEquals(Enum::BOOLEAN_FALSE(), Enum::valueOf('BOOLEAN_FALSE'));
        $this->assertEquals(Enum::INTEGER_ZERO(), Enum::valueOf('INTEGER_ZERO'));
        $this->assertEquals(Enum::INTEGER_ONE(), Enum::valueOf('INTEGER_ONE'));
        $this->assertEquals(Enum::INTEGER_MINUS_TWO(), Enum::valueOf('INTEGER_MINUS_TWO'));
        $this->assertEquals(Enum::INTEGER_THREE(), Enum::valueOf('INTEGER_THREE'));
        $this->assertEquals(Enum::FLOAT_ZERO(), Enum::valueOf('FLOAT_ZERO'));
        $this->assertEquals(Enum::FLOAT_MINUS_POINT_ONE(), Enum::valueOf('FLOAT_MINUS_POINT_ONE'));
        $this->assertEquals(Enum::FLOAT_POINT_ONE(), Enum::valueOf('FLOAT_POINT_ONE'));
        $this->assertEquals(Enum::FLOAT_ONE(), Enum::valueOf('FLOAT_ONE'));
        $this->assertEquals(Enum::STRING_EMPTY(), Enum::valueOf('STRING_EMPTY'));
        $this->assertEquals(Enum::STRING_INTEGER_ONE(), Enum::valueOf('STRING_INTEGER_ONE'));
        $this->assertEquals(Enum::STRING_ONE(), Enum::valueOf('STRING_ONE'));
        $this->assertEquals(Enum::STRING_EOF(), Enum::valueOf('STRING_EOF'));
        $this->assertEquals(Enum::ARRAY_EMPTY(), Enum::valueOf('ARRAY_EMPTY'));
        $this->assertEquals(Enum::ARRAY_ONE(), Enum::valueOf('ARRAY_ONE'));
        $this->assertEquals(Enum::ARRAY_FLOAT_TWO(), Enum::valueOf('ARRAY_FLOAT_TWO'));
        $this->assertEquals(Enum::ARRAY_STRING(), Enum::valueOf('ARRAY_STRING'));
        $this->assertEquals(Enum::NULL_NULL(), Enum::valueOf('NULL_NULL'));
    }

    public function testEnumValue()
    {
        $this->assertEquals(TRUE, Enum::BOOLEAN_TRUE()->getValue());
        $this->assertEquals(FALSE, Enum::BOOLEAN_FALSE()->getValue());
        $this->assertEquals(0, Enum::INTEGER_ZERO()->getValue());
        $this->assertEquals(1, Enum::INTEGER_ONE()->getValue());
        $this->assertEquals(-2, Enum::INTEGER_MINUS_TWO()->getValue());
        $this->assertEquals(3, Enum::INTEGER_THREE()->getValue());
        $this->assertEquals(0.0, Enum::FLOAT_ZERO()->getValue());
        $this->assertEquals(-1.0, Enum::FLOAT_MINUS_POINT_ONE()->getValue());
        $this->assertEquals(0.1, Enum::FLOAT_POINT_ONE()->getValue());
        $this->assertEquals(0.555 + 0.512 - 0.067, Enum::FLOAT_ONE()->getValue());
        $this->assertEquals('', Enum::STRING_EMPTY()->getValue());
        $this->assertEquals('1', Enum::STRING_INTEGER_ONE()->getValue());
        $this->assertEquals('one', Enum::STRING_ONE()->getValue());
        $this->assertEquals('    This is a very long text.', Enum::STRING_EOF()->getValue());
        $this->assertEquals([], Enum::ARRAY_EMPTY()->getValue());
        $this->assertEquals([1], Enum::ARRAY_ONE()->getValue());
        $this->assertEquals([0.3-0.1=>0.2], Enum::ARRAY_FLOAT_TWO()->getValue());
        $this->assertEquals(['This' => ['is' => 'a', ['array']]], Enum::ARRAY_STRING()->getValue());
        $this->assertEquals(NULL, Enum::NULL_NULL()->getValue());
    }
}