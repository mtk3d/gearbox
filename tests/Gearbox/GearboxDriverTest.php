<?php

namespace Mtk3d\Gearbox\Tests\Gearbox;

use Mtk3d\Gearbox\ExternalSystems;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Sport;
use Mtk3d\Gearbox\Gearbox\Exception\ActionSequenceException;
use Mtk3d\Gearbox\Gearbox\GearboxDriver;
use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\GearMode;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use PHPUnit\Framework\TestCase;

class GearboxDriverTest extends TestCase
{
    /**
     * @var GearboxInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $gearbox;
    /**
     * @var ExternalSystems|\PHPUnit\Framework\MockObject\MockObject
     */
    private $externalSystems;

    public function setUp(): void
    {
        $this->gearbox = $this->createMock(GearboxInterface::class);
        $this->externalSystems = $this->createMock(ExternalSystems::class);
    }

    public function testGearboxDriverHandler() {
        //given
        $gearboxDriver = new GearboxDriver($this->gearbox, $this->externalSystems);
        //then
        $this->externalSystems->method('getCurrentRpm')->willReturn((float)900);
        $this->gearbox->expects($this->once())->method('shiftDown');
        //when
        $gearboxDriver->handle(GasPedal::of(0.5), BreakPedal::of(0));
    }

    public function testChangeDrivingMode() {
        //given
        $gearboxDriver = new GearboxDriver($this->gearbox, $this->externalSystems);
        //then
        $this->externalSystems->method('getCurrentRpm')->willReturn((float)4900);
        $this->gearbox->expects($this->exactly(2))->method('shiftDown');
        //when
        $gearboxDriver->changeDrivingMode(new Sport());
        $gearboxDriver->handle(GasPedal::of(0), BreakPedal::of(0.95));
    }

    public function testChangeGearMode() {
        //given
        $gearboxDriver = new GearboxDriver($this->gearbox, $this->externalSystems);
        $neutral = GearMode::neutral();
        //then
        $this->gearbox->expects($this->once())->method('changeGearMode')->with($neutral);
        //when
        $gearboxDriver->changeGearMode($neutral);
    }

    public function testFailedToChangeGearMode() {
        //given
        $gearboxDriver = new GearboxDriver($this->gearbox, $this->externalSystems);
        $park = GearMode::park();
        //then
        $this->gearbox->expects($this->never())->method('changeGearMode');
        $this->expectException(ActionSequenceException::class);
        //when
        $gearboxDriver->changeGearMode($park);
    }
}
