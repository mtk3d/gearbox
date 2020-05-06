<?php


use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use PHPUnit\Framework\TestCase;

class BreakPedalTest extends TestCase
{
    public function testCreateBreakPedal()
    {
        //given
        $threshold = 0.5;
        //when
        $breakPedal = BreakPedal::of($threshold);
        //then
        $this->assertEquals($threshold, $breakPedal->threshold()->value());
    }
}
