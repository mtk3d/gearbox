<?php

namespace Mtk3d\Gearbox\Tests\Gearbox;

use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\Aggressiveness;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Sport;
use Mtk3d\Gearbox\Gearbox\Exception\ActionSequenceException;
use Mtk3d\Gearbox\Gearbox\Exception\GearOutOfRangeException;
use Mtk3d\Gearbox\Gearbox\ExternalSystemsInterface;
use Mtk3d\Gearbox\Gearbox\Gear;
use Mtk3d\Gearbox\Gearbox\GearboxDriver;
use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\GearMode;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GearboxDriverTest extends TestCase
{
    /**
     * @var GearboxInterface|MockObject
     */
    private $gearbox;
    /**
     * @var ExternalSystemsInterface|MockObject
     */
    private $externalSystems;

    public function setUp(): void
    {
        $this->gearbox = $this->createMock(GearboxInterface::class);
        $this->externalSystems = $this->createMock(ExternalSystemsInterface::class);
    }

    public function testGearboxDriverHandler() {
        //given
        $gearboxDriver = GearboxDriver::init($this->gearbox, $this->externalSystems);
        //then
        $this->externalSystems->method('getCurrentRpm')->willReturn(Rpm::of(900));
        $this->gearbox->expects($this->once())->method('shiftDown');
        //when
        $gearboxDriver->handle(GasPedal::of(0.5), BreakPedal::of(0));
    }

    public function testGearboxDriverHandlerShiftUp() {
        //given
        $gearboxDriver = GearboxDriver::init($this->gearbox, $this->externalSystems);
        //then
        $this->externalSystems->method('getCurrentRpm')->willReturn(Rpm::of(2600));
        $this->gearbox->expects($this->once())->method('shiftUp');
        //when
        $gearboxDriver->handle(GasPedal::of(0.5), BreakPedal::of(0));
    }

    public function testChangeDrivingMode() {
        //given
        $gearboxDriver = GearboxDriver::init($this->gearbox, $this->externalSystems);
        //then
        $this->externalSystems->method('getCurrentRpm')->willReturn(Rpm::of(4900));
        $this->gearbox->expects($this->exactly(2))->method('shiftDown');
        //when
        $gearboxDriver->changeDrivingMode(new Sport(Aggressiveness::first()));
        $gearboxDriver->handle(GasPedal::of(0), BreakPedal::of(0.95));
    }

    public function testChangeGearMode() {
        //given
        $gearboxDriver = GearboxDriver::init($this->gearbox, $this->externalSystems);
        $neutral = GearMode::neutral();
        //then
        $this->gearbox->expects($this->once())->method('changeGearMode')->with($neutral);
        //when
        $gearboxDriver->changeGearMode($neutral);
    }

    public function testFailedToChangeGearMode() {
        //given
        $gearboxDriver = GearboxDriver::init($this->gearbox, $this->externalSystems);
        $park = GearMode::park();
        //then
        $this->gearbox->expects($this->never())->method('changeGearMode');
        $this->expectException(ActionSequenceException::class);
        //when
        $gearboxDriver->changeGearMode($park);
    }

    public function testManualyChangeGear() {
        //given
        $newGear = Gear::of(4);
        $gearboxDriver = GearboxDriver::init($this->gearbox, $this->externalSystems);
        //then
        $this->gearbox->expects($this->once())->method('changeGear')->with($newGear);
        //when
        $gearboxDriver->changeGear($newGear);
    }

    public function testManualyChangeGearOutOfRange() {
        //given
        $newGear = Gear::of(4);
        $gearboxDriver = GearboxDriver::init($this->gearbox, $this->externalSystems);
        //then
        $this->gearbox
            ->expects($this->once())
            ->method('changeGear')
            ->with($newGear)
            ->willThrowException(new GearOutOfRangeException);
        $this->expectException(GearOutOfRangeException::class);
        //when
        $gearboxDriver->changeGear($newGear);
    }
}
