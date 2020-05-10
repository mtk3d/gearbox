<?php

namespace Mtk3d\Gearbox\Tests\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\Aggressiveness;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Sport;
use Mtk3d\Gearbox\Gearbox\ExternalSystemsInterface;
use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use PHPUnit\Framework\TestCase;

//TODO: refactor tests to check gearbox function calls
class SportTest extends TestCase
{
    /**
     * @var Sport
     */
    private Sport $sport;

    public function setUp(): void
    {
        $this->sport = new Sport(Aggressiveness::first());
    }

    public function testShouldShiftDown()
    {
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(1400)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(1600)
        );
        //when
        $should = $this->sport->shouldShiftDown($inputStateShould);
        $shouldNot = $this->sport->shouldShiftDown($inputStateShouldNot);
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
            Rpm::of(2900)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0),
            BreakPedal::of(0.1),
            Rpm::of(2900)
        );
        //when
        $should = $this->sport->shouldShiftDown($inputStateShould);
        $shouldNot = $this->sport->shouldShiftDown($inputStateShouldNot);
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
            Rpm::of(5100)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.2),
            BreakPedal::of(0),
            Rpm::of(4900)
        );
        //when
        $should = $this->sport->shouldShiftUp($inputStateShould);
        $shouldNot = $this->sport->shouldShiftUp($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }

    public function testShouldShiftDownInKickdown()
    {
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0),
            BreakPedal::of(0.8),
            Rpm::of(4900)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.8),
            BreakPedal::of(0.8),
            Rpm::of(5100)
        );
        //when
        $should = $this->sport->shouldShiftDown($inputStateShould);
        $shouldNot = $this->sport->shouldShiftDown($inputStateShouldNot);
        $shouldNotTwoGears = $this->sport->shouldShiftDownTwoGears(BreakPedal::of(0.8), Rpm::of(4900));
        $shouldNotTwoGearsToo = $this->sport->shouldShiftDownTwoGears(BreakPedal::of(0.8), Rpm::of(5100));
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
        $this->assertFalse($shouldNotTwoGears);
        $this->assertFalse($shouldNotTwoGearsToo);
    }

    public function testShouldShiftDownTwoGearsInKickdown()
    {
        //given
        $inputState = InputState::of(
            GasPedal::of(0),
            BreakPedal::of(0.95),
            Rpm::of(4900)
        );
        //when
        $should = $this->sport->shouldShiftDown($inputState);
        $twoGears = $this->sport->shouldShiftDownTwoGears(BreakPedal::of(0.95), Rpm::of(4900));
        //then
        $this->assertTrue($should);
        $this->assertTrue($twoGears);
    }

    public function testChangeTwoGearsInKickdown()
    {
        //given
        $externalSystems = $this->createMock(ExternalSystemsInterface::class);
        $gearbox = $this->createMock(GearboxInterface::class);
        //than
        $gearbox->expects($this->exactly(2))
            ->method('shiftDown');
        //when
        $this->sport->handle(GasPedal::of(0), BreakPedal::of(0.95), $gearbox, $externalSystems);
    }

    public function testShouldShiftDownInSecondAggressiveness()
    {
        $this->sport = new Sport(Aggressiveness::second());
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(1700)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(1900)
        );
        //when
        $should = $this->sport->shouldShiftDown($inputStateShould);
        $shouldNot = $this->sport->shouldShiftDown($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }

    public function testShouldShiftDownInThirdAggressiveness()
    {
        $this->sport = new Sport(Aggressiveness::third());
        //given
        $inputStateShould = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(1700)
        );
        $inputStateShouldNot = InputState::of(
            GasPedal::of(0.5),
            BreakPedal::of(0),
            Rpm::of(1900)
        );
        //when
        $should = $this->sport->shouldShiftDown($inputStateShould);
        $shouldNot = $this->sport->shouldShiftDown($inputStateShouldNot);
        //then
        $this->assertTrue($should);
        $this->assertFalse($shouldNot);
    }
}
