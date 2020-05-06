<?php

namespace Mtk3d\Gearbox\Gearbox;

use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GearTest extends TestCase
{
    /**
     * @var Gear
     */
    private Gear $gear;

    public function setUp(): void
    {
        $this->gear = Gear::of(1);
    }

    public function testChangeGear()
    {
        //given $this->gear
        //when
        $gear = $this->gear->change(3);
        //then
        $this->assertEquals(3, $gear->current());
    }

    public function testSetGearOutOfRange()
    {
        //given $this->gear
        //then
        $this->expectException(InvalidArgumentException::class);
        //when
        $this->gear->change(-1);
    }

    public function testShiftDownOnLowestGear()
    {
        //given $this->gear
        //when
        $this->gear->change(2);
        $this->gear->shiftDown();
        $this->gear->shiftDown();
        $this->gear->shiftDown();
        //then
        $this->assertEquals(1, $this->gear->current());
    }
}
