<?php

namespace PhpEnum\Tests;

use PhpEnum\Exceptions\IllegalArgumentException;
use PhpEnum\Exceptions\InstantiationException;
use PhpEnum\Exceptions\PropertyNotFoundException;
use PHPUnit\Framework\TestCase;

class PhpEnumTest extends TestCase
{
    public function testEnumGet()
    {
        $this->assertEquals(0, PhpEnum::ZERO()->getInteger());
        $this->assertEquals(0.0, PhpEnum::ZERO()->getFloat());
        $this->assertEquals('', PhpEnum::ZERO()->getString());
        $this->assertEquals([], PhpEnum::ZERO()->getArray());
        $this->assertEquals(false, PhpEnum::ZERO()->getBoolean());
        $this->assertEquals(null, PhpEnum::ZERO()->getNull());

        $this->assertEquals(4+6-8, PhpEnum::ONE()->getInteger());
        $this->assertEquals(2.45+4.234-6.4177, PhpEnum::ONE()->getFloat());
        $this->assertEquals('This is a very long text.', PhpEnum::ONE()->getString());
        $this->assertEquals(['This' => ['is' => 'a', ['array']]], PhpEnum::ONE()->getArray());
        $this->assertEquals(true, PhpEnum::ONE()->getBoolean());
        $this->assertEquals(null, PhpEnum::ONE()->getNull());
    }

    public function testEnumEquals()
    {
        $this->assertTrue(PhpEnum::ZERO()->enumNameEquals('ZERO'));
        $this->assertTrue(PhpEnum::ZERO()->integerEquals(0));
        $this->assertTrue(PhpEnum::ZERO()->floatEquals(0.0));
        $this->assertTrue(PhpEnum::ZERO()->stringEquals(''));
        $this->assertTrue(PhpEnum::ZERO()->arrayEquals([]));
        $this->assertTrue(PhpEnum::ZERO()->booleanEquals(false));
        $this->assertTrue(PhpEnum::ZERO()->nullEquals(null));

        $this->assertTrue(PhpEnum::ONE()->enumNameEquals('ONE'));
        $this->assertTrue(PhpEnum::ONE()->integerEquals(4+6-8));
        $this->assertTrue(PhpEnum::ONE()->floatEquals(2.45+4.234-6.4177));
        $this->assertTrue(PhpEnum::ONE()->stringEquals('This is a very long text.'));
        $this->assertTrue(PhpEnum::ONE()->arrayEquals(['This' => ['is' => 'a', ['array']]]));
        $this->assertTrue(PhpEnum::ONE()->booleanEquals(true));
        $this->assertTrue(PhpEnum::ONE()->nullEquals(null));
    }

    /**
     * @throws IllegalArgumentException
     * @throws InstantiationException
     */
    public function testEnumContains()
    {
        $this->assertTrue(PhpEnum::containsEnumName('ZERO'));
        $this->assertTrue(PhpEnum::containsEnumName('ONE'));

        $this->assertEquals(1, PhpEnum::containsInteger(0));
        $this->assertEquals(1, PhpEnum::containsFloat(0.0));
        $this->assertEquals(1, PhpEnum::containsString(''));
        $this->assertEquals(1, PhpEnum::containsArray([]));
        $this->assertEquals(1, PhpEnum::containsBoolean(false));
        $this->assertEquals(2, PhpEnum::containsNull(null));

        $this->assertEquals(1, PhpEnum::containsInteger(4+6-8));
        $this->assertEquals(1, PhpEnum::containsFloat(2.45+4.234-6.4177));
        $this->assertEquals(1, PhpEnum::containsString('This is a very long text.'));
        $this->assertEquals(1, PhpEnum::containsArray(['This' => ['is' => 'a', ['array']]]));
        $this->assertEquals(1, PhpEnum::containsBoolean(true));
    }

    public function testEnumOf()
    {
        $this->assertEquals(PhpEnum::ZERO(), PhpEnum::ofInteger(0));
        $this->assertEquals(PhpEnum::ZERO(), PhpEnum::ofFloat(0.0));
        $this->assertEquals(PhpEnum::ZERO(), PhpEnum::ofString(''));
        $this->assertEquals(PhpEnum::ZERO(), PhpEnum::ofArray([]));
        $this->assertEquals(PhpEnum::ZERO(), PhpEnum::ofBoolean(false));
        $this->assertEquals(PhpEnum::ZERO(), PhpEnum::ofNull(null, "ZE"));

        $this->assertEquals(PhpEnum::ONE(), PhpEnum::ofInteger(4+6-8));
        $this->assertEquals(PhpEnum::ONE(), PhpEnum::ofFloat(2.45+4.234-6.4177));
        $this->assertEquals(PhpEnum::ONE(), PhpEnum::ofString('This is a very long text.'));
        $this->assertEquals(PhpEnum::ONE(), PhpEnum::ofArray(['This' => ['is' => 'a', ['array']]]));
        $this->assertEquals(PhpEnum::ONE(), PhpEnum::ofBoolean(true));
        $this->assertEquals(PhpEnum::ONE(), PhpEnum::ofNull(null, "ON"));
    }

    /**
     * @throws PropertyNotFoundException
     * @throws IllegalArgumentException
     * @throws InstantiationException
     */
    public function testEnumArray()
    {
        $this->assertArrayHasKey('ZERO', PhpEnum::properties('integer'));
        $this->assertArrayHasKey('ZERO', PhpEnum::properties('float'));
        $this->assertArrayHasKey('ZERO', PhpEnum::properties('string'));
        $this->assertArrayHasKey('ZERO', PhpEnum::properties('array'));
        $this->assertArrayHasKey('ZERO', PhpEnum::properties('boolean'));
        $this->assertArrayHasKey('ZERO', PhpEnum::properties('null'));

        $this->assertArrayHasKey('ONE', PhpEnum::properties('integer'));
        $this->assertArrayHasKey('ONE', PhpEnum::properties('float'));
        $this->assertArrayHasKey('ONE', PhpEnum::properties('string'));
        $this->assertArrayHasKey('ONE', PhpEnum::properties('array'));
        $this->assertArrayHasKey('ONE', PhpEnum::properties('boolean'));
        $this->assertArrayHasKey('ONE', PhpEnum::properties('null'));
    }
}