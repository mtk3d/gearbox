<?php

namespace Mtk3d\Gearbox\Gearbox;

use Mtk3d\Gearbox\Gearbox\Pedal\Pedal;
use PHPUnit\Framework\TestCase;
use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;

class PedalTest extends TestCase
{
    public function testCreateBreakPedal()
    {
        //given
        $threshold = 0.5;
        //when
        $breakPedal = Pedal::of($threshold);
        //then
        $this->assertEquals($threshold, $breakPedal->threshold()->value());
    }

    public function testCreateGasPedalOfInvalidArg()
    {
        //given
        $threshold = 2;
        //then
        $this->expectException(InvalidArgumentException::class);
        //when
        $pedalThreshold = Pedal::of($threshold);
    }
}
