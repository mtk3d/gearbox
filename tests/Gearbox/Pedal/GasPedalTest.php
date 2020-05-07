<?php

namespace Mtk3d\Gearbox\Tests\Gearbox\Pedal;

use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use PHPUnit\Framework\TestCase;

class GasPedalTest extends TestCase
{
    public function testCreateGasPedal()
    {
        //given
        $threshold = 0.5;
        //when
        $gasPedal = GasPedal::of($threshold);
        //then
        $this->assertEquals($threshold, $gasPedal->threshold()->value());
    }
}
