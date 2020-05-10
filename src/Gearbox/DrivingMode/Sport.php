<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;


use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\AggressivenessInterface;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\DownshiftInSportSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\DownshiftOnBrakeInSportSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\DownshiftOnKickdownInSportSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\DownshiftOnStrongKickdownInSportSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\KickdownInSportSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\StrongKickdownInSportSpecification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\UpshiftInSportSpecification;
use Mtk3d\Gearbox\Gearbox\ExternalSystemsInterface;
use Mtk3d\Gearbox\Gearbox\GearboxInterface;
use Mtk3d\Gearbox\Gearbox\InputState;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\PressedSpecification;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

class Sport extends DrivingMode
{
    /**
     * @var PressedSpecification
     */
    private PressedSpecification $pressedSpecification;
    /**
     * @var KickdownInSportSpecification
     */
    private KickdownInSportSpecification $kickDownSpecification;
    /**
     * @var DownshiftInSportSpecification
     */
    private DownshiftInSportSpecification $downShiftSpecification;
    /**
     * @var DownshiftOnBrakeInSportSpecification
     */
    private DownshiftOnBrakeInSportSpecification $downShiftOnBreakSpecification;
    /**
     * @var UpshiftInSportSpecification
     */
    private UpshiftInSportSpecification $upShiftSpecification;
    /**
     * @var StrongKickdownInSportSpecification
     */
    private StrongKickdownInSportSpecification $strongKickdownSpecification;
    /**
     * @var DownshiftOnKickdownInSportSpecification
     */
    private DownshiftOnKickdownInSportSpecification $downShiftInKickdownSpecification;
    /**
     * @var DownshiftOnStrongKickdownInSportSpecification
     */
    private DownshiftOnStrongKickdownInSportSpecification $downShiftOnStrongKickdownSpecification;

    public function __construct(AggressivenessInterface $aggressiveness)
    {
        $this->pressedSpecification = new PressedSpecification();
        $this->kickDownSpecification = new KickdownInSportSpecification();
        $this->downShiftSpecification = new DownshiftInSportSpecification($aggressiveness);
        $this->downShiftOnBreakSpecification = new DownshiftOnBrakeInSportSpecification($aggressiveness);
        $this->downShiftInKickdownSpecification = new DownshiftOnKickdownInSportSpecification($aggressiveness);
        $this->upShiftSpecification = new UpshiftInSportSpecification($aggressiveness);
        $this->strongKickdownSpecification = new StrongKickdownInSportSpecification();
        $this->downShiftOnStrongKickdownSpecification = new DownshiftOnStrongKickdownInSportSpecification($aggressiveness);
    }

    public function handle(GasPedal $gas, BreakPedal $break, GearboxInterface $gearbox, ExternalSystemsInterface $externalSystems): void
    {
        if ($this->shouldShiftDownTwoGears($break, $externalSystems->getCurrentRpm())) {
            $gearbox->shiftDown(); //one more time
        }
        parent::handle($gas, $break, $gearbox, $externalSystems);
    }

    public function shouldShiftDown(InputState $inputState): bool
    {
        if ($this->strongKickdownSpecification->isSatisfiedBy($inputState->getBreak())) {
            return $this->downShiftOnStrongKickdownSpecification->isSatisfiedBy($inputState->getCurrentRpm());
        }

        if ($this->kickDownSpecification->isSatisfiedBy($inputState->getBreak())) {
            return $this->downShiftInKickdownSpecification->isSatisfiedBy($inputState->getCurrentRpm());
        }

        if ($this->pressedSpecification->isSatisfiedBy($inputState->getBreak())) {
            return $this->downShiftOnBreakSpecification->isSatisfiedBy($inputState->getCurrentRpm());
        }

        return $this->downShiftSpecification->isSatisfiedBy($inputState->getCurrentRpm());
    }

    public function shouldShiftUp(InputState $inputState): bool
    {
        return $this->upShiftSpecification->isSatisfiedBy($inputState->getCurrentRpm());
    }

    public function shouldShiftDownTwoGears(BreakPedal $break, Rpm $currentRpm)
    {
        return $this->strongKickdownSpecification->isSatisfiedBy($break)
            && $this->downShiftOnStrongKickdownSpecification->isSatisfiedBy($currentRpm);
    }
}