<?php

namespace Mtk3d\Gearbox\Gearbox;

interface GearboxInterface
{
//    public function changeGearMode(GearMode $gearMode): void;
    public function currentGearModeEquals(GearMode $gearMode): bool;
    public function changeGearMode(GearMode $gearMode): void;
    public function changeGear(Gear $gear): void;

    public function shiftDown(): void;
    public function shiftUp(): void;
}