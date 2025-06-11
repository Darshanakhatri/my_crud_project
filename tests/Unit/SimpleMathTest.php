<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class SimpleMathTest extends TestCase
{
    public function testAddition(): void
    {
        $a = 5;
        $b = 3;
        $sum = $a + $b;

        $this->assertEquals(8, $sum, '5 + 3 should equal 8');
    }
}
