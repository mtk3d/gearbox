<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\AggressivenessInterface;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Eco\ShiftDownInEco;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Eco\ShiftDownOnBrakeInEco;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Eco\ShiftUpInEco;
use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\PressedSpecification;

class Eco extends DrivingMode
{
    /**
     * @var PressedSpecification
     */
    private PressedSpecification $pressed;
    /**
     * @var ShiftDownInEco
     */
    private ShiftDownInEco $shiftDown;
    /**
     * @var ShiftDownOnBrakeInEco
     */
    private ShiftDownOnBrakeInEco $shiftDownOnBreak;
    /**
     * @var ShiftUpInEco
     */
    private ShiftUpInEco $shiftUp;

    /**
     * Eco constructor.
     * @param AggressivenessInterface $aggressiveness
     * @throws InvalidArgumentException
     */
    public function __construct(AggressivenessInterface $aggressiveness)
    {
        $this->pressed = new PressedSpecification();
        $this->shiftDown = new ShiftDownInEco();
        $this->shiftDownOnBreak = new ShiftDownOnBrakeInEco();
        $this->shiftUp = new ShiftUpInEco();
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
        return $this->shiftUp->isSatisfiedBy($inputState->getCurrentRpm());
    }
}