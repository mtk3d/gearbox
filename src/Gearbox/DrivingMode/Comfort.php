<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;

use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\DownshiftInComfortSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\DownshiftOnBrakeInComfortSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\KickdownInComfortSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\UpshiftInComfortSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort\UpshiftOnKickdownInComfortSpecification;
use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\PressedSpecification;

class Comfort extends DrivingMode
{
    /**
     * @var PressedSpecification
     */
    private PressedSpecification $pressedSpecification;
    /**
     * @var KickdownInComfortSpecification
     */
    private KickdownInComfortSpecification $kickDownSpecification;
    /**
     * @var DownshiftInComfortSpecification
     */
    private DownshiftInComfortSpecification $downShiftSpecification;
    /**
     * @var DownshiftOnBrakeInComfortSpecification
     */
    private DownshiftOnBrakeInComfortSpecification $downShiftOnBreakSpecification;
    /**
     * @var UpshiftOnKickdownInComfortSpecification
     */
    private UpshiftOnKickdownInComfortSpecification $upShiftInKickdownSpecification;
    /**
     * @var UpshiftInComfortSpecification
     */
    private UpshiftInComfortSpecification $upShiftSpecification;

    public function __construct()
    {
        $this->pressedSpecification = new PressedSpecification();
        $this->kickDownSpecification = new KickdownInComfortSpecification();
        $this->downShiftSpecification = new DownshiftInComfortSpecification();
        $this->downShiftOnBreakSpecification = new DownshiftOnBrakeInComfortSpecification();
        $this->upShiftInKickdownSpecification = new UpshiftOnKickdownInComfortSpecification();
        $this->upShiftSpecification = new UpshiftInComfortSpecification();
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
        if ($this->kickDownSpecification->isSatisfiedBy($inputState->getGas())) {
            return $this->upShiftInKickdownSpecification->isSatisfiedBy($inputState->getCurrentRpm());
        }

        return $this->upShiftSpecification->isSatisfiedBy($inputState->getCurrentRpm());
    }
}