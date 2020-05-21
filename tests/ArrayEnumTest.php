<?php

namespace PhpEnum\Tests;

class ArrayEnumTest extends \PHPUnit\Framework\TestCase
{

    public function testEnum()
    {
        $this->assertEquals(ArticleEnum::STATUS_NORMAL()->getKey(), 1);
    }

}