<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;


use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\PressedSpecification;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\Eco\DownshiftInEcoSpecification;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\Eco\DownshiftOnBrakeInEcoSpecification;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\Eco\UpshiftInEcoSpecification;

class Eco extends DrivingMode
{
    /**
     * @var PressedSpecification
     */
    private PressedSpecification $pressedSpecification;
    /**
     * @var DownshiftInEcoSpecification
     */
    private DownshiftInEcoSpecification $downShiftSpecification;
    /**
     * @var DownshiftOnBrakeInEcoSpecification
     */
    private DownshiftOnBrakeInEcoSpecification $downShiftOnBreakSpecification;
    /**
     * @var UpshiftInEcoSpecification
     */
    private UpshiftInEcoSpecification $upShiftSpecification;

    public function __construct()
    {
        $this->pressedSpecification = new PressedSpecification();
        $this->downShiftSpecification = new DownshiftInEcoSpecification();
        $this->downShiftOnBreakSpecification = new DownshiftOnBrakeInEcoSpecification();
        $this->upShiftSpecification = new UpshiftInEcoSpecification();
    }

    public function shouldShiftDown(InputState $inputState): bool
    {
        if ($this->pressedSpecification->isSatisfiedBy($inputState->getBreak())) {
            return $this->downShiftOnBreakSpecification->isSatisfiedBy($inputState->getCurrentRpm());
        }

        return $this->downShiftSpecification->isSatisfiedBy($inputState->getCurrentRpm());
    }

    public function shouldShiftUp(InputState $inputState): bool
    {
        return $this->upShiftSpecification->isSatisfiedBy($inputState->getCurrentRpm());
    }
}