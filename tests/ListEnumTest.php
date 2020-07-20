<?php

namespace PhpEnum\Tests;

use PHPUnit\Framework\TestCase;

class ListEnumTest extends TestCase
{

    public function testEnumType()
    {
        $this->assertTrue(ListEnum::ONE()->getBoolean());
        $this->assertFalse(ListEnum::EMPTY()->getBoolean());
        $this->assertIsInt(ListEnum::ONE()->getInteger());
        $this->assertIsNumeric(ListEnum::ONE()->getNumber());
        $this->assertIsFloat(ListEnum::ONE()->getFloat());
        $this->assertIsString(ListEnum::ONE()->getString());
        $this->assertIsArray(ListEnum::ONE()->getArray());
        $this->assertNull(ListEnum::ONE()->getNull());
    }

    public function testEnumName()
    {
        $this->assertEquals(ListEnum::EMPTY()->name(), 'EMPTY');
        $this->assertEquals(ListEnum::ONE()->name(), 'ONE');
        $this->assertEquals(ListEnum::TWO()->name(), 'TWO');
    }

    public function testEnumValue()
    {
        $this->assertEquals(ListEnum::ONE()->getInteger(), 1);
        $this->assertEquals(ListEnum::ONE()->getFloat(), 1.0);
        $this->assertEquals(ListEnum::ONE()->getNumber(), -1);
        $this->assertEquals(ListEnum::ONE()->getString(), '1');
        $this->assertEquals(ListEnum::ONE()->getArray(), [1]);
        $this->assertEquals(ListEnum::ONE()->getBoolean(), TRUE);
        $this->assertEquals(ListEnum::ONE()->getNull(), NULL);
    }

    public function testEnumNameEquals()
    {
        $this->assertTrue(ListEnum::EMPTY()->nameEquals('EMPTY'));
        $this->assertTrue(ListEnum::ONE()->nameEquals('ONE'));
        $this->assertTrue(ListEnum::TWO()->nameEquals('TWO'));
    }

    public function testEnumNames()
    {
        $names = ListEnum::names();
        $this->assertContains('EMPTY', $names);
        $this->assertContains('ONE', $names);
        $this->assertContains('TWO', $names);
    }

    public function testEnumValues()
    {
        $values = ListEnum::values();
        $this->assertArrayHasKey('EMPTY', $values);
        $this->assertArrayHasKey('ONE', $values);
        $this->assertArrayHasKey('TWO', $values);
    }

    public function testEnumEnums()
    {
        $enums = ListEnum::enums();
        $this->assertTrue(ListEnum::EMPTY()->equals($enums['EMPTY']));
        $this->assertTrue(ListEnum::ONE()->equals($enums['ONE']));
        $this->assertTrue(ListEnum::TWO()->equals($enums['TWO']));
    }

    public function testEnumHasName()
    {
        $this->assertTrue(ListEnum::hasName('EMPTY'));
        $this->assertTrue(ListEnum::hasName('ONE'));
        $this->assertTrue(ListEnum::hasName('TWO'));
    }

    public function testEnumByName()
    {
        $this->assertTrue(ListEnum::byName('EMPTY')->equals(ListEnum::EMPTY()));
        $this->assertTrue(ListEnum::byName('ONE')->equals(ListEnum::ONE()));
        $this->assertTrue(ListEnum::byName('TWO')->equals(ListEnum::TWO()));
    }

    public function testEnumCount()
    {
        $this->assertCount(ListEnum::count(), ListEnum::names());
        $this->assertCount(ListEnum::count(), ListEnum::values());
        $this->assertCount(ListEnum::count(), ListEnum::enums());
    }

}