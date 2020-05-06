<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use PHPUnit\Framework\TestCase;

class ComfortTest extends TestCase
{
    /**
     * @var Comfort
     */
    private Comfort $comfort;

    public function setUp(): void
    {
        $this->comfort = new Comfort();
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
        $should = $this->comfort->shouldShiftDown($inputStateShould);
        $shouldNot = $this->comfort->shouldShiftDown($inputStateShouldNot);
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
            Rpm::of(1900)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0),
            BreakPedal::of(0.1),
            Rpm::of(1900)
        );
        //when
        $should = $this->comfort->shouldShiftDown($inputStateShould);
        $shouldNot = $this->comfort->shouldShiftDown($inputStateShouldNot);
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
            Rpm::of(2600)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.2),
            BreakPedal::of(0),
            Rpm::of(2300)
        );
        //when
        $should = $this->comfort->shouldShiftUp($inputStateShould);
        $shouldNot = $this->comfort->shouldShiftUp($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }

    public function testShouldShiftUpInKickdown()
    {
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0.9),
            BreakPedal::of(0),
            Rpm::of(4600)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.9),
            BreakPedal::of(0),
            Rpm::of(4400)
        );
        //when
        $should = $this->comfort->shouldShiftUp($inputStateShould);
        $shouldNot = $this->comfort->shouldShiftUp($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }
}
