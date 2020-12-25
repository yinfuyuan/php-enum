<?php

namespace PhpEnum\Tests;

use PhpEnum\Exceptions\PropertyNotFoundException;
use PHPUnit\Framework\TestCase;

class ListEnumTest extends TestCase
{

    public function testEnumGet()
    {
        $this->assertEquals(0, ListEnum::ZERO()->getInteger());
        $this->assertEquals(0.0, ListEnum::ZERO()->getFloat());
        $this->assertEquals('', ListEnum::ZERO()->getString());
        $this->assertEquals([], ListEnum::ZERO()->getArray());
        $this->assertEquals(false, ListEnum::ZERO()->getBoolean());
        $this->assertEquals(null, ListEnum::ZERO()->getNull());

        $this->assertEquals(4+6-8, ListEnum::ONE()->getInteger());
        $this->assertEquals(2.45+4.234-6.4177, ListEnum::ONE()->getFloat());
        $this->assertEquals('This is a very long text.', ListEnum::ONE()->getString());
        $this->assertEquals(['This' => ['is' => 'a', ['array']]], ListEnum::ONE()->getArray());
        $this->assertEquals(true, ListEnum::ONE()->getBoolean());
        $this->assertEquals(null, ListEnum::ONE()->getNull());
    }

    public function testEnumEquals()
    {
        $this->assertTrue(ListEnum::ZERO()->integerEquals(0));
        $this->assertTrue(ListEnum::ZERO()->floatEquals(0.0));
        $this->assertTrue(ListEnum::ZERO()->stringEquals(''));
        $this->assertTrue(ListEnum::ZERO()->arrayEquals([]));
        $this->assertTrue(ListEnum::ZERO()->booleanEquals(false));
        $this->assertTrue(ListEnum::ZERO()->nullEquals(null));

        $this->assertTrue(ListEnum::ONE()->integerEquals(4+6-8));
        $this->assertTrue(ListEnum::ONE()->floatEquals(2.45+4.234-6.4177));
        $this->assertTrue(ListEnum::ONE()->stringEquals('This is a very long text.'));
        $this->assertTrue(ListEnum::ONE()->arrayEquals(['This' => ['is' => 'a', ['array']]]));
        $this->assertTrue(ListEnum::ONE()->booleanEquals(true));
        $this->assertTrue(ListEnum::ONE()->nullEquals(null));
    }

    public function testEnumContains()
    {
        $this->assertEquals(1, ListEnum::containsInteger(0));
        $this->assertEquals(1, ListEnum::containsFloat(0.0));
        $this->assertEquals(1, ListEnum::containsString(''));
        $this->assertEquals(1, ListEnum::containsArray([]));
        $this->assertEquals(1, ListEnum::containsBoolean(false));
        $this->assertEquals(2, ListEnum::containsNull(null));

        $this->assertEquals(1, ListEnum::containsInteger(4+6-8));
        $this->assertEquals(1, ListEnum::containsFloat(2.45+4.234-6.4177));
        $this->assertEquals(1, ListEnum::containsString('This is a very long text.'));
        $this->assertEquals(1, ListEnum::containsArray(['This' => ['is' => 'a', ['array']]]));
        $this->assertEquals(1, ListEnum::containsBoolean(true));
    }

    public function testEnumOf()
    {
        $this->assertEquals(ListEnum::ZERO(), ListEnum::ofInteger(0));
        $this->assertEquals(ListEnum::ZERO(), ListEnum::ofFloat(0.0));
        $this->assertEquals(ListEnum::ZERO(), ListEnum::ofString(''));
        $this->assertEquals(ListEnum::ZERO(), ListEnum::ofArray([]));
        $this->assertEquals(ListEnum::ZERO(), ListEnum::ofBoolean(false));
        $this->assertEquals(ListEnum::ZERO(), ListEnum::ofNull(null, "ZE"));

        $this->assertEquals(ListEnum::ONE(), ListEnum::ofInteger(4+6-8));
        $this->assertEquals(ListEnum::ONE(), ListEnum::ofFloat(2.45+4.234-6.4177));
        $this->assertEquals(ListEnum::ONE(), ListEnum::ofString('This is a very long text.'));
        $this->assertEquals(ListEnum::ONE(), ListEnum::ofArray(['This' => ['is' => 'a', ['array']]]));
        $this->assertEquals(ListEnum::ONE(), ListEnum::ofBoolean(true));
        $this->assertEquals(ListEnum::ONE(), ListEnum::ofNull(null, "ON"));
    }

    /**
     * @throws PropertyNotFoundException
     */
    public function testEnumArray()
    {
        $this->assertArrayHasKey('ZERO', ListEnum::getProperties('integer'));
        $this->assertArrayHasKey('ZERO', ListEnum::getProperties('float'));
        $this->assertArrayHasKey('ZERO', ListEnum::getProperties('string'));
        $this->assertArrayHasKey('ZERO', ListEnum::getProperties('array'));
        $this->assertArrayHasKey('ZERO', ListEnum::getProperties('boolean'));
        $this->assertArrayHasKey('ZERO', ListEnum::getProperties('null'));

        $this->assertArrayHasKey('ONE', ListEnum::getProperties('integer'));
        $this->assertArrayHasKey('ONE', ListEnum::getProperties('float'));
        $this->assertArrayHasKey('ONE', ListEnum::getProperties('string'));
        $this->assertArrayHasKey('ONE', ListEnum::getProperties('array'));
        $this->assertArrayHasKey('ONE', ListEnum::getProperties('boolean'));
        $this->assertArrayHasKey('ONE', ListEnum::getProperties('null'));
    }

}