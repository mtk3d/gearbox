<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\InputState;

abstract class DrivingMode
{
    public function handle(InputState $inputState, GearboxInterface $gearbox): void
    {
        if ($this->shouldShiftDown($inputState)) {
            $gearbox->shiftDown();
        } elseif ($this->shouldShiftUp($inputState)) {
            $gearbox->shiftUp();
        }
    }

    abstract public function shouldShiftDown(InputState $inputState): bool;
    abstract public function shouldShiftUp(InputState $inputState): bool;
}