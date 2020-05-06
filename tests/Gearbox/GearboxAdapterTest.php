<?php

namespace Mtk3d\Gearbox\Gearbox;

use PHPUnit\Framework\TestCase;

class GearboxAdapterTest extends TestCase
{
    /**
     * @var Gearbox|\PHPUnit\Framework\MockObject\MockObject
     */
    private $gearboxMock;

    public function setUp(): void
    {
        $this->gearboxMock = $this->createMock(Gearbox::class);
        $this->gearboxMock->method('getMaxDrive')
            ->willReturn(6);
    }

    public function testGearboxAdapterCreate()
    {
        //given
        $gearboxAdapter = GearboxAdapter::init(Gear::of(6));
        //then
        $this->assertInstanceOf(GearboxAdapter::class, $gearboxAdapter);
    }

    public function testGearboxAdapterWithTargetGearboxCommunication()
    {
        //given
        $gearboxAdapter = new GearboxAdapter($this->gearboxMock, Gear::of(1), GearMode::neutral(), Gear::of(6));
        //then
        $this->gearboxMock->expects($this->once())
            ->method('setGearBoxCurrentParams')
            ->with([4, 2]);
        //when
        $gearboxAdapter->changeGear(Gear::of(2));
    }

    public function testGearboxAdapterShiftUp()
    {
        //given
        $gearboxAdapter = new GearboxAdapter($this->gearboxMock, Gear::of(1), GearMode::neutral(), Gear::of(6));
        //then
        $this->gearboxMock->expects($this->once())
            ->method('setGearBoxCurrentParams')
            ->with([4, 2]);
        //when
        $gearboxAdapter->shiftUp();
    }

    public function testGearboxAdapterShiftUpMaxGear()
    {
        //given
        $gearboxAdapter = new GearboxAdapter($this->gearboxMock, Gear::of(6), GearMode::neutral(), Gear::of(6));
        //then
        $this->gearboxMock->expects($this->never())
            ->method('setGearBoxCurrentParams');
        //when
        $gearboxAdapter->shiftUp();
    }

    public function testGearboxAdapterShiftDown()
    {
        //given
        $gearboxAdapter = new GearboxAdapter($this->gearboxMock, Gear::of(3), GearMode::neutral(), Gear::of(6));
        //then
        $this->gearboxMock->expects($this->once())
            ->method('setGearBoxCurrentParams')
            ->with([4, 2]);
        //when
        $gearboxAdapter->shiftDown();
    }

    public function testChangeGearMode()
    {
        //given
        $gearboxAdapter = new GearboxAdapter($this->gearboxMock, Gear::of(3), GearMode::neutral(), Gear::of(6));
        //then
        $this->gearboxMock->expects($this->once())
            ->method('setGearBoxCurrentParams')
            ->with([1, 3]);
        //when
        $gearboxAdapter->changeGearMode(GearMode::drive());
    }

    public function testCurrentGearModeEquals()
    {
        //given
        $gearboxAdapter = new GearboxAdapter($this->gearboxMock, Gear::of(3), GearMode::neutral(), Gear::of(6));
        //then
        $this->assertTrue($gearboxAdapter->currentGearModeEquals(GearMode::neutral()));
    }
}
