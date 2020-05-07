<?php

namespace Mtk3d\Gearbox\Gearbox\Tests;

use Mtk3d\Gearbox\Gearbox\Gearbox;
use PHPUnit\Framework\TestCase;

class GearboxTest extends TestCase
{
    public function testThatGearboxAPIWorks()
    {
        //given
        $gearbox = new Gearbox();
        //when
        $gearbox->setGearBoxCurrentParams([
            1,
            3
        ]);
        //then
        $this->assertEquals(1, $gearbox->getState());
        $this->assertEquals(3, $gearbox->getCurrentGear());
    }

    public function testSetMaxGear()
    {
        //given
        $gearbox = new Gearbox();
        //when
        $gearbox->setMaxDrive(5);
        //then
        $this->assertEquals(5, $gearbox->getMaxDrive());
    }

    public function testSetNeutralGear()
    {
        //given
        $gearbox = new Gearbox();
        //when
        $gearbox->setGearBoxCurrentParams([
            4,
            2
        ]);
        //then
        $this->assertEquals(4, $gearbox->getState());
        $this->assertEquals(0, $gearbox->getCurrentGear());
    }

    public function testSetReverseGear()
    {
        //given
        $gearbox = new Gearbox();
        //when
        $gearbox->setGearBoxCurrentParams([
            3,
            2
        ]);
        //then
        $this->assertEquals(3, $gearbox->getState());
        $this->assertEquals(-1, $gearbox->getCurrentGear());
    }

    public function testSetParkGear()
    {
        //given
        $gearbox = new Gearbox();
        //when
        $gearbox->setGearBoxCurrentParams([
            2,
            2
        ]);
        //then
        $this->assertEquals(2, $gearbox->getState());
        $this->assertEquals(0, $gearbox->getCurrentGear());
    }
}
