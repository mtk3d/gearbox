<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\InputState;

abstract class DrivingMode
{
    /**
     * @param InputState $inputState
     * @param GearboxInterface $gearbox
     */
    public function handle(InputState $inputState, GearboxInterface $gearbox): void
    {
        if ($this->shouldShiftDown($inputState)) {
            $gearbox->shiftDown();
        } elseif ($this->shouldShiftUp($inputState)) {
            $gearbox->shiftUp();
        }
    }

    /**
     * @param InputState $inputState
     * @return bool
     */
    abstract public function shouldShiftDown(InputState $inputState): bool;

    /**
     * @param InputState $inputState
     * @return bool
     */
    abstract public function shouldShiftUp(InputState $inputState): bool;
}