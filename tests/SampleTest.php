<?php

namespace App\Tests;

use App\Sample;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testSample(): void
    {
        $this->assertEquals(42, (new Sample())->example());
    }
}