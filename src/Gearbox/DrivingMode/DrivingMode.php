<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Gearbox\ExternalSystemsInterface;
use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;

abstract class DrivingMode
{
    /**
     * @param GasPedal $gas
     * @param BreakPedal $break
     * @param GearboxInterface $gearbox
     * @param ExternalSystemsInterface $externalSystems
     */
    public function handle(GasPedal $gas, BreakPedal $break, GearboxInterface $gearbox, ExternalSystemsInterface $externalSystems): void
    {
        $inputState = InputState::of($gas, $break, $externalSystems->getCurrentRpm());

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