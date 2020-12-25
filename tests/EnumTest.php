<?php

namespace PhpEnum\Tests;

use PhpEnum\Exceptions\EnumConflictException;
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

        $this->assertEquals('boolean', gettype(Enum::BOOLEAN_TRUE()->value()));
        $this->assertEquals('boolean', gettype(Enum::BOOLEAN_FALSE()->value()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_ZERO()->value()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_ONE()->value()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_MINUS_TWO()->value()));
        $this->assertEquals('integer', gettype(Enum::INTEGER_THREE()->value()));
        $this->assertEquals('double', gettype(Enum::FLOAT_ZERO()->value()));
        $this->assertEquals('double', gettype(Enum::FLOAT_MINUS_POINT_ONE()->value()));
        $this->assertEquals('double', gettype(Enum::FLOAT_POINT_ONE()->value()));
        $this->assertEquals('double', gettype(Enum::FLOAT_ONE()->value()));
        $this->assertEquals('string', gettype(Enum::STRING_EMPTY()->value()));
        $this->assertEquals('string', gettype(Enum::STRING_INTEGER_ONE()->value()));
        $this->assertEquals('string', gettype(Enum::STRING_ONE()->value()));
        $this->assertEquals('string', gettype(Enum::STRING_EOF()->value()));
        $this->assertEquals('array', gettype(Enum::ARRAY_EMPTY()->value()));
        $this->assertEquals('array', gettype(Enum::ARRAY_ONE()->value()));
        $this->assertEquals('array', gettype(Enum::ARRAY_FLOAT_TWO()->value()));
        $this->assertEquals('array', gettype(Enum::ARRAY_STRING()->value()));
        $this->assertEquals('NULL', gettype(Enum::NULL_NULL()->value()));
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

    public function testEnumValue()
    {
        $this->assertEquals(TRUE, Enum::BOOLEAN_TRUE()->value());
        $this->assertEquals(FALSE, Enum::BOOLEAN_FALSE()->value());
        $this->assertEquals(0, Enum::INTEGER_ZERO()->value());
        $this->assertEquals(1, Enum::INTEGER_ONE()->value());
        $this->assertEquals(-2, Enum::INTEGER_MINUS_TWO()->value());
        $this->assertEquals(3, Enum::INTEGER_THREE()->value());
        $this->assertEquals(0.0, Enum::FLOAT_ZERO()->value());
        $this->assertEquals(-1.0, Enum::FLOAT_MINUS_POINT_ONE()->value());
        $this->assertEquals(0.1, Enum::FLOAT_POINT_ONE()->value());
        $this->assertEquals(0.555 + 0.512 - 0.067, Enum::FLOAT_ONE()->value());
        $this->assertEquals('', Enum::STRING_EMPTY()->value());
        $this->assertEquals('1', Enum::STRING_INTEGER_ONE()->value());
        $this->assertEquals('one', Enum::STRING_ONE()->value());
        $this->assertEquals('    This is a very long text.', Enum::STRING_EOF()->value());
        $this->assertEquals([], Enum::ARRAY_EMPTY()->value());
        $this->assertEquals([1], Enum::ARRAY_ONE()->value());
        $this->assertEquals([0.3-0.1=>0.2], Enum::ARRAY_FLOAT_TWO()->value());
        $this->assertEquals(['This' => ['is' => 'a', ['array']]], Enum::ARRAY_STRING()->value());
        $this->assertEquals(NULL, Enum::NULL_NULL()->value());
    }

    public function testEnumNameEquals()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->enumNameEquals('BOOLEAN_TRUE'));
        $this->assertTrue(Enum::BOOLEAN_FALSE()->enumNameEquals('BOOLEAN_FALSE'));
        $this->assertTrue(Enum::INTEGER_ZERO()->enumNameEquals('INTEGER_ZERO'));
        $this->assertTrue(Enum::INTEGER_ONE()->enumNameEquals('INTEGER_ONE'));
        $this->assertTrue(Enum::INTEGER_MINUS_TWO()->enumNameEquals('INTEGER_MINUS_TWO'));
        $this->assertTrue(Enum::INTEGER_THREE()->enumNameEquals('INTEGER_THREE'));
        $this->assertTrue(Enum::FLOAT_ZERO()->enumNameEquals('FLOAT_ZERO'));
        $this->assertTrue(Enum::FLOAT_MINUS_POINT_ONE()->enumNameEquals('FLOAT_MINUS_POINT_ONE'));
        $this->assertTrue(Enum::FLOAT_POINT_ONE()->enumNameEquals('FLOAT_POINT_ONE'));
        $this->assertTrue(Enum::FLOAT_ONE()->enumNameEquals('FLOAT_ONE'));
        $this->assertTrue(Enum::STRING_EMPTY()->enumNameEquals('STRING_EMPTY'));
        $this->assertTrue(Enum::STRING_INTEGER_ONE()->enumNameEquals('STRING_INTEGER_ONE'));
        $this->assertTrue(Enum::STRING_ONE()->enumNameEquals('STRING_ONE'));
        $this->assertTrue(Enum::STRING_EOF()->enumNameEquals('STRING_EOF'));
        $this->assertTrue(Enum::ARRAY_EMPTY()->enumNameEquals('ARRAY_EMPTY'));
        $this->assertTrue(Enum::ARRAY_ONE()->enumNameEquals('ARRAY_ONE'));
        $this->assertTrue(Enum::ARRAY_FLOAT_TWO()->enumNameEquals('ARRAY_FLOAT_TWO'));
        $this->assertTrue(Enum::ARRAY_STRING()->enumNameEquals('ARRAY_STRING'));
        $this->assertTrue(Enum::NULL_NULL()->enumNameEquals('NULL_NULL'));
    }

    public function testEnumValueEquals()
    {
        $this->assertTrue(Enum::BOOLEAN_TRUE()->enumValueEquals(TRUE));
        $this->assertTrue(Enum::BOOLEAN_FALSE()->enumValueEquals(FALSE));
        $this->assertTrue(Enum::INTEGER_ZERO()->enumValueEquals(0));
        $this->assertTrue(Enum::INTEGER_ONE()->enumValueEquals(1));
        $this->assertTrue(Enum::INTEGER_MINUS_TWO()->enumValueEquals(-2));
        $this->assertTrue(Enum::INTEGER_THREE()->enumValueEquals(3));
        $this->assertTrue(Enum::FLOAT_ZERO()->enumValueEquals(0.0));
        $this->assertTrue(Enum::FLOAT_MINUS_POINT_ONE()->enumValueEquals(-1.0));
        $this->assertTrue(Enum::FLOAT_POINT_ONE()->enumValueEquals(0.1));
        $this->assertTrue(Enum::FLOAT_ONE()->enumValueEquals(0.555 + 0.512 - 0.067));
        $this->assertTrue(Enum::STRING_EMPTY()->enumValueEquals(''));
        $this->assertTrue(Enum::STRING_INTEGER_ONE()->enumValueEquals('1'));
        $this->assertTrue(Enum::STRING_ONE()->enumValueEquals('one'));
        $this->assertTrue(Enum::STRING_EOF()->enumValueEquals('    This is a very long text.'));
        $this->assertTrue(Enum::ARRAY_EMPTY()->enumValueEquals([]));
        $this->assertTrue(Enum::ARRAY_ONE()->enumValueEquals([1]));
        $this->assertTrue(Enum::ARRAY_FLOAT_TWO()->enumValueEquals([0.3-0.1=>0.2]));
        $this->assertTrue(Enum::ARRAY_STRING()->enumValueEquals(['This' => ['is' => 'a', ['array']]]));
        $this->assertTrue(Enum::NULL_NULL()->enumValueEquals(NULL));
    }

    public function testEnumEnums()
    {
        $enums = Enum::enums();
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

    public function testEnumNames()
    {
        $names = Enum::names();
        $this->assertContains('BOOLEAN_TRUE', $names);
        $this->assertContains('BOOLEAN_FALSE', $names);
        $this->assertContains('INTEGER_ZERO', $names);
        $this->assertContains('INTEGER_ONE', $names);
        $this->assertContains('INTEGER_MINUS_TWO', $names);
        $this->assertContains('INTEGER_THREE', $names);
        $this->assertContains('FLOAT_ZERO', $names);
        $this->assertContains('FLOAT_MINUS_POINT_ONE', $names);
        $this->assertContains('FLOAT_POINT_ONE', $names);
        $this->assertContains('FLOAT_ONE', $names);
        $this->assertContains('STRING_EMPTY', $names);
        $this->assertContains('STRING_INTEGER_ONE', $names);
        $this->assertContains('STRING_ONE', $names);
        $this->assertContains('STRING_EOF', $names);
        $this->assertContains('ARRAY_EMPTY', $names);
        $this->assertContains('ARRAY_ONE', $names);
        $this->assertContains('ARRAY_FLOAT_TWO', $names);
        $this->assertContains('ARRAY_STRING', $names);
        $this->assertContains('NULL_NULL', $names);
    }

    public function testEnumValues()
    {
        $values = Enum::values();
        $this->assertEquals(TRUE, $values['BOOLEAN_TRUE']);
        $this->assertEquals(FALSE, $values['BOOLEAN_FALSE']);
        $this->assertEquals(0, $values['INTEGER_ZERO']);
        $this->assertEquals(1, $values['INTEGER_ONE']);
        $this->assertEquals(-2, $values['INTEGER_MINUS_TWO']);
        $this->assertEquals(3, $values['INTEGER_THREE']);
        $this->assertEquals(0.0, $values['FLOAT_ZERO']);
        $this->assertEquals(-1.0, $values['FLOAT_MINUS_POINT_ONE']);
        $this->assertEquals(0.1, $values['FLOAT_POINT_ONE']);
        $this->assertEquals(0.555 + 0.512 - 0.067, $values['FLOAT_ONE']);
        $this->assertEquals('', $values['STRING_EMPTY']);
        $this->assertEquals('1', $values['STRING_INTEGER_ONE']);
        $this->assertEquals('one', $values['STRING_ONE']);
        $this->assertEquals('    This is a very long text.', $values['STRING_EOF']);
        $this->assertEquals([], $values['ARRAY_EMPTY']);
        $this->assertEquals([1], $values['ARRAY_ONE']);
        $this->assertEquals([0.3-0.1=>0.2], $values['ARRAY_FLOAT_TWO']);
        $this->assertEquals(['This' => ['is' => 'a', ['array']]], $values['ARRAY_STRING']);
        $this->assertEquals(NULL, $values['NULL_NULL']);
    }

    public function testEnumContainsName()
    {
        $this->assertEquals(1, Enum::containsEnumName('BOOLEAN_TRUE'));
        $this->assertEquals(1, Enum::containsEnumName('BOOLEAN_FALSE'));
        $this->assertEquals(1, Enum::containsEnumName('INTEGER_ZERO'));
        $this->assertEquals(1, Enum::containsEnumName('INTEGER_ONE'));
        $this->assertEquals(1, Enum::containsEnumName('INTEGER_MINUS_TWO'));
        $this->assertEquals(1, Enum::containsEnumName('INTEGER_THREE'));
        $this->assertEquals(1, Enum::containsEnumName('FLOAT_ZERO'));
        $this->assertEquals(1, Enum::containsEnumName('FLOAT_MINUS_POINT_ONE'));
        $this->assertEquals(1, Enum::containsEnumName('FLOAT_POINT_ONE'));
        $this->assertEquals(1, Enum::containsEnumName('FLOAT_ONE'));
        $this->assertEquals(1, Enum::containsEnumName('STRING_EMPTY'));
        $this->assertEquals(1, Enum::containsEnumName('STRING_INTEGER_ONE'));
        $this->assertEquals(1, Enum::containsEnumName('STRING_ONE'));
        $this->assertEquals(1, Enum::containsEnumName('STRING_EOF'));
        $this->assertEquals(1, Enum::containsEnumName('ARRAY_EMPTY'));
        $this->assertEquals(1, Enum::containsEnumName('ARRAY_ONE'));
        $this->assertEquals(1, Enum::containsEnumName('ARRAY_FLOAT_TWO'));
        $this->assertEquals(1, Enum::containsEnumName('ARRAY_STRING'));
        $this->assertEquals(1, Enum::containsEnumName('NULL_NULL'));
    }

    public function testEnumContainsValue()
    {
        $this->assertEquals(1, Enum::containsEnumValue(TRUE));
        $this->assertEquals(1, Enum::containsEnumValue(FALSE));
        $this->assertEquals(1, Enum::containsEnumValue(0));
        $this->assertEquals(1, Enum::containsEnumValue(1));
        $this->assertEquals(1, Enum::containsEnumValue(-2));
        $this->assertEquals(1, Enum::containsEnumValue(3));
        $this->assertEquals(1, Enum::containsEnumValue(0.0));
        $this->assertEquals(1, Enum::containsEnumValue(-1.0));
        $this->assertEquals(1, Enum::containsEnumValue(0.1));
        $this->assertEquals(1, Enum::containsEnumValue(0.555 + 0.512 - 0.067));
        $this->assertEquals(1, Enum::containsEnumValue(''));
        $this->assertEquals(1, Enum::containsEnumValue('1'));
        $this->assertEquals(1, Enum::containsEnumValue('one'));
        $this->assertEquals(1, Enum::containsEnumValue('    This is a very long text.'));
        $this->assertEquals(1, Enum::containsEnumValue([]));
        $this->assertEquals(1, Enum::containsEnumValue([1]));
        $this->assertEquals(1, Enum::containsEnumValue([0.3-0.1=>0.2]));
        $this->assertEquals(1, Enum::containsEnumValue(['This' => ['is' => 'a', ['array']]]));
        $this->assertEquals(1, Enum::containsEnumValue(NULL));
    }

    public function testEnumOfName()
    {
        $this->assertTrue(Enum::ofEnumName('BOOLEAN_TRUE')->equals(Enum::BOOLEAN_TRUE()));
        $this->assertTrue(Enum::ofEnumName('BOOLEAN_TRUE')->equals(Enum::BOOLEAN_TRUE()));
        $this->assertTrue(Enum::ofEnumName('BOOLEAN_FALSE')->equals(Enum::BOOLEAN_FALSE()));
        $this->assertTrue(Enum::ofEnumName('INTEGER_ZERO')->equals(Enum::INTEGER_ZERO()));
        $this->assertTrue(Enum::ofEnumName('INTEGER_ONE')->equals(Enum::INTEGER_ONE()));
        $this->assertTrue(Enum::ofEnumName('INTEGER_MINUS_TWO')->equals(Enum::INTEGER_MINUS_TWO()));
        $this->assertTrue(Enum::ofEnumName('INTEGER_THREE')->equals(Enum::INTEGER_THREE()));
        $this->assertTrue(Enum::ofEnumName('FLOAT_ZERO')->equals(Enum::FLOAT_ZERO()));
        $this->assertTrue(Enum::ofEnumName('FLOAT_MINUS_POINT_ONE')->equals(Enum::FLOAT_MINUS_POINT_ONE()));
        $this->assertTrue(Enum::ofEnumName('FLOAT_POINT_ONE')->equals(Enum::FLOAT_POINT_ONE()));
        $this->assertTrue(Enum::ofEnumName('FLOAT_ONE')->equals(Enum::FLOAT_ONE()));
        $this->assertTrue(Enum::ofEnumName('STRING_EMPTY')->equals(Enum::STRING_EMPTY()));
        $this->assertTrue(Enum::ofEnumName('STRING_INTEGER_ONE')->equals(Enum::STRING_INTEGER_ONE()));
        $this->assertTrue(Enum::ofEnumName('STRING_ONE')->equals(Enum::STRING_ONE()));
        $this->assertTrue(Enum::ofEnumName('STRING_EOF')->equals(Enum::STRING_EOF()));
        $this->assertTrue(Enum::ofEnumName('ARRAY_EMPTY')->equals(Enum::ARRAY_EMPTY()));
        $this->assertTrue(Enum::ofEnumName('ARRAY_ONE')->equals(Enum::ARRAY_ONE()));
        $this->assertTrue(Enum::ofEnumName('ARRAY_FLOAT_TWO')->equals(Enum::ARRAY_FLOAT_TWO()));
        $this->assertTrue(Enum::ofEnumName('ARRAY_STRING')->equals(Enum::ARRAY_STRING()));
        $this->assertTrue(Enum::ofEnumName('NULL_NULL')->equals(Enum::NULL_NULL()));
    }

    /**
     * @throws EnumConflictException
     */
    public function testEnumOfValue()
    {
        $this->assertTrue(Enum::ofEnumValue(TRUE)->equals(Enum::BOOLEAN_TRUE()));
        $this->assertTrue(Enum::ofEnumValue(FALSE)->equals(Enum::BOOLEAN_FALSE()));
        $this->assertTrue(Enum::ofEnumValue(0)->equals(Enum::INTEGER_ZERO()));
        $this->assertTrue(Enum::ofEnumValue(1)->equals(Enum::INTEGER_ONE()));
        $this->assertTrue(Enum::ofEnumValue(-2)->equals(Enum::INTEGER_MINUS_TWO()));
        $this->assertTrue(Enum::ofEnumValue(3)->equals(Enum::INTEGER_THREE()));
        $this->assertTrue(Enum::ofEnumValue(0.0)->equals(Enum::FLOAT_ZERO()));
        $this->assertTrue(Enum::ofEnumValue(-1.0)->equals(Enum::FLOAT_MINUS_POINT_ONE()));
        $this->assertTrue(Enum::ofEnumValue(0.1)->equals(Enum::FLOAT_POINT_ONE()));
        $this->assertTrue(Enum::ofEnumValue(0.555 + 0.512 - 0.067)->equals(Enum::FLOAT_ONE()));
        $this->assertTrue(Enum::ofEnumValue('')->equals(Enum::STRING_EMPTY()));
        $this->assertTrue(Enum::ofEnumValue('1')->equals(Enum::STRING_INTEGER_ONE()));
        $this->assertTrue(Enum::ofEnumValue('one')->equals(Enum::STRING_ONE()));
        $this->assertTrue(Enum::ofEnumValue('    This is a very long text.')->equals(Enum::STRING_EOF()));
        $this->assertTrue(Enum::ofEnumValue([])->equals(Enum::ARRAY_EMPTY()));
        $this->assertTrue(Enum::ofEnumValue([1])->equals(Enum::ARRAY_ONE()));
        $this->assertTrue(Enum::ofEnumValue([0.3-0.1=>0.2])->equals(Enum::ARRAY_FLOAT_TWO()));
        $this->assertTrue(Enum::ofEnumValue(['This' => ['is' => 'a', ['array']]])->equals(Enum::ARRAY_STRING()));
        $this->assertTrue(Enum::ofEnumValue(NULL)->equals(Enum::NULL_NULL()));
    }

    public function testEnumCount()
    {
        $this->assertCount(Enum::count(), Enum::names());
        $this->assertCount(Enum::count(), Enum::values());
        $this->assertCount(Enum::count(), Enum::enums());
        $this->assertCount(Enum::count('BOOLEAN'), Enum::names('BOOLEAN'));
        $this->assertCount(Enum::count('INTEGER'), Enum::names('INTEGER'));
        $this->assertCount(Enum::count('FLOAT'), Enum::names('FLOAT'));
        $this->assertCount(Enum::count('STRING'), Enum::names('STRING'));
        $this->assertCount(Enum::count('ARRAY'), Enum::names('ARRAY'));
        $this->assertCount(Enum::count('NULL'), Enum::names('NULL'));
    }
}