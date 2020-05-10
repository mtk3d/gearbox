<?php

namespace Mtk3d\Gearbox\Tests\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\Aggressiveness;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Eco;
use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use PHPUnit\Framework\TestCase;

//TODO: refactor tests to check gearbox function calls
class EcoTest extends TestCase
{
    private Eco $eco;

    public function setUp(): void
    {
        $this->eco = new Eco(Aggressiveness::first());
    }

    public function testShouldShiftDown()
    {
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(999)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(1500)
        );
        //when
        $should = $this->eco->shouldShiftDown($inputStateShould);
        $shouldNot = $this->eco->shouldShiftDown($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }

    public function testShouldShiftDownInBreaking()
    {
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0),
            BreakPedal::of(0.5),
            Rpm::of(1400)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0),
            BreakPedal::of(0.1),
            Rpm::of(1400)
        );
        //when
        $should = $this->eco->shouldShiftDown($inputStateShould);
        $shouldNot = $this->eco->shouldShiftDown($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }

    public function testShouldShiftUp()
    {
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0.2),
            BreakPedal::of(0),
            Rpm::of(2100)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.2),
            BreakPedal::of(0),
            Rpm::of(1900)
        );
        //when
        $should = $this->eco->shouldShiftUp($inputStateShould);
        $shouldNot = $this->eco->shouldShiftUp($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }
}
