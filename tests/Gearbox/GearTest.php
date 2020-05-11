<?php

namespace Mtk3d\Gearbox\Gearbox\Tests;

use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\Exception\GearOutOfRangeException;
use Mtk3d\Gearbox\Gearbox\Gear;
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

    public function testCreateGearOfValue()
    {
        //given
        $gear = Gear::of(5);
        //then
        $this->assertEquals(5, $gear->current());
    }

    public function testSetGearOutOfRange()
    {
        //given
        //then
        $this->expectException(GearOutOfRangeException::class);
        //when
        Gear::of(-1);
    }
}
