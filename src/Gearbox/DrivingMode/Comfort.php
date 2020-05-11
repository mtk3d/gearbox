<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\AggressivenessInterface;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\ShiftDownInComfort;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\ShiftDownOnBrakeInComfort;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\KickDownInComfort;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\ShiftUpInComfort;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\ShiftUpOnKickDownInComfort;
use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\PressedSpecification;

class Comfort extends DrivingMode
{
    /**
     * @var PressedSpecification
     */
    private PressedSpecification $pressed;
    /**
     * @var KickDownInComfort
     */
    private KickDownInComfort $kickDown;
    /**
     * @var ShiftDownInComfort
     */
    private ShiftDownInComfort $shiftDown;
    /**
     * @var ShiftDownOnBrakeInComfort
     */
    private ShiftDownOnBrakeInComfort $shiftDownOnBreak;
    /**
     * @var ShiftUpOnKickDownInComfort
     */
    private ShiftUpOnKickDownInComfort $ShiftUpInKickDown;
    /**
     * @var ShiftUpInComfort
     */
    private ShiftUpInComfort $shiftUp;

    /**
     * Comfort constructor.
     * @param AggressivenessInterface $aggressiveness
     * @throws InvalidArgumentException
     */
    public function __construct(AggressivenessInterface $aggressiveness)
    {
        $this->pressed = new PressedSpecification();
        $this->kickDown = new KickDownInComfort();
        $this->shiftDown = new ShiftDownInComfort($aggressiveness);
        $this->shiftDownOnBreak = new ShiftDownOnBrakeInComfort($aggressiveness);
        $this->ShiftUpInKickDown = new ShiftUpOnKickDownInComfort($aggressiveness);
        $this->shiftUp = new ShiftUpInComfort($aggressiveness);
    }

    /**
     * @inheritDoc
     */
    public function shouldShiftDown(InputState $inputState): bool
    {
        if ($this->pressed->isSatisfiedBy($inputState->getBreak())) {
            return $this->shiftDownOnBreak->isSatisfiedBy($inputState->getCurrentRpm());
        }

        return $this->shiftDown->isSatisfiedBy($inputState->getCurrentRpm());
    }

    /**
     * @inheritDoc
     */
    public function shouldShiftUp(InputState $inputState): bool
    {
        if ($this->kickDown->isSatisfiedBy($inputState->getGas())) {
            return $this->ShiftUpInKickDown->isSatisfiedBy($inputState->getCurrentRpm());
        }

        return $this->shiftUp->isSatisfiedBy($inputState->getCurrentRpm());
    }
}