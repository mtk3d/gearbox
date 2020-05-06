<?php

use Mtk3d\Gearbox\Gearbox\Pedal\PedalThreshold;
use PHPUnit\Framework\TestCase;
use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;

class PedalThresholdTest extends TestCase
{
    public function testCreatePedalThreshold()
    {
        //given
        $threshold = 0.5;
        //when
        $pedalThreshold = PedalThreshold::of($threshold);
        //then
        $this->assertEquals($threshold, $pedalThreshold->value());
    }

    public function testCreatePedalThresholdOfInvalidArg()
    {
        //given
        $threshold = 2;
        //then
        $this->expectException(InvalidArgumentException::class);
        //when
        $pedalThreshold = PedalThreshold::of($threshold);
    }
}
