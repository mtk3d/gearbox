<?php

namespace Mtk3d\Gearbox\Tests\Gearbox\Rpm;

use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use PHPUnit\Framework\TestCase;

class RpmTest extends TestCase
{
    public function testRpm()
    {
        //given
        $value = 1000;
        //when
        $rpm = Rpm::of($value);
        //then
        $this->assertEquals($value, $rpm->value());
    }

    public function testInvalidRpm()
    {
        //given
        $value = -10;
        //then
        $this->expectException(InvalidArgumentException::class);
        //when
        $rpm = Rpm::of($value);
    }
}
