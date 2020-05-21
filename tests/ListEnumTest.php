<?php

namespace PhpEnum\Tests;

class ListEnumTest extends \PHPUnit\Framework\TestCase
{

    public function testEnum()
    {
        $this->assertEquals(ErrorCodeEnum::OK()->A, '0');
    }

}