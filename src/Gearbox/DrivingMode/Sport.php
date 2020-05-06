<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;


use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\InputState;

class Sport extends DrivingMode
{
    public function handle(InputState $inputState, GearboxInterface $gearbox): void
    {
        // TODO: if should shift 2 gears
        parent::handle($inputState, $gearbox);
    }

    public function shouldShiftDown(InputState $inputState): bool
    {
        // TODO: Implement shouldShiftDown() method.
    }

    public function shouldShiftUp(InputState $inputState): bool
    {
        // TODO: Implement shouldShiftUp() method.
    }
}