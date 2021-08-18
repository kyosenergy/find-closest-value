<?php

namespace Kyos\FindClosestValue\Tests;

use Kyos\FindClosestValue\FindClosestValue;
use PHPUnit\Framework\TestCase;

class FindClosestValueTest extends TestCase
{
    /** @test */
    public function it_throws_if_array_is_empty()
    {
        $this->expectException(\InvalidArgumentException::class);

        (new FindClosestValue())->findClosest([], 5);
    }

    /** @test */
    public function it_finds_the_closest_value()
    {
        $fcv = new FindClosestValue();
        // sorted array
        $arr = [-78, -10, 4, 7, 23, 96, 102];

        // lower boundary
        $this->assertEquals(-78, $fcv->findClosest($arr, -78));
        $this->assertEquals(-78, $fcv->findClosest($arr, -100));

        // higher boundary
        $this->assertEquals(102, $fcv->findClosest($arr, 102));
        $this->assertEquals(102, $fcv->findClosest($arr, 150));

        // equidistant
        $this->assertEquals(102, $fcv->findClosest($arr, 100));

        // exact match not boundary
        $this->assertEquals(7, $fcv->findClosest($arr, 7));

        // normal cases
        $this->assertEquals(-10, $fcv->findClosest($arr, -7));

        $this->assertEquals(23, $fcv->findClosest($arr, 50));
        $this->assertEquals(96, $fcv->findClosest($arr, 80));
    }

    /** @test */
    public function it_finds_the_closest_float_value()
    {
        $fcv = new FindClosestValue();
        // unsorted array
        $arr = [1.34, 0.56, 0, 1.76, 0.76];

        // lower boundary
        $this->assertEquals(0, $fcv->findClosest($arr, -0.000001));

        // higher boundary
        $this->assertEquals(1.76, $fcv->findClosest($arr, 2));

        // exact match not boundary
        $this->assertEquals(0, $fcv->findClosest($arr, 0));

        // equidistant
        $this->assertEquals(0.56, $fcv->findClosest($arr, 0.66));

        // normal cases
        $this->assertEquals(0.76, $fcv->findClosest($arr, 0.70));
        $this->assertEquals(0.56, $fcv->findClosest($arr, 0.60));
        $this->assertEquals(0, $fcv->findClosest($arr, 0.1));
        $this->assertEquals(0.76, $fcv->findClosest($arr, 1));
        $this->assertEquals(1.34, $fcv->findClosest($arr, 1.1));
    }
}
