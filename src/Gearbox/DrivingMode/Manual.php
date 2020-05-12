<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;


use Mtk3d\Gearbox\Gearbox\InputState;

class Manual extends DrivingMode
{
    /**
     * @inheritDoc
     */
    public function shouldShiftDown(InputState $inputState): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function shouldShiftUp(InputState $inputState): bool
    {
        return false;
    }
}