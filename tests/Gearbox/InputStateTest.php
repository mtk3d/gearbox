<?php

namespace Mtk3d\Gearbox\Gearbox;

use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use PHPUnit\Framework\TestCase;

class InputStateTest extends TestCase
{
    public function testCreateInputState()
    {
        //given
        $pedalGas = GasPedal::of(.5);
        $pedalBreak = BreakPedal::of(0);
        $currentRpm = Rpm::of(1000);
        //when
        $inputState = InputState::of($pedalGas, $pedalBreak, $currentRpm);
        //then
        $this->assertEquals($pedalGas, $inputState->getGas());
        $this->assertEquals($pedalBreak, $inputState->getBreak());
        $this->assertEquals($currentRpm, $inputState->getCurrentRpm());
    }
}
