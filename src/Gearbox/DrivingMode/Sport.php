<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\AggressivenessInterface;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\ShiftDownInSport;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\ShiftDownOnBrakeInSport;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\ShiftDownOnKickDownInSport;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\ShiftDownOnStrongKickDownInSport;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\KickDownInSport;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\StrongKickDownInSport;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport\ShiftUpInSport;
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
    private PressedSpecification $pressed;
    /**
     * @var KickDownInSport
     */
    private KickDownInSport $kickDown;
    /**
     * @var ShiftDownInSport
     */
    private ShiftDownInSport $shiftDown;
    /**
     * @var ShiftDownOnBrakeInSport
     */
    private ShiftDownOnBrakeInSport $shiftDownOnBreak;
    /**
     * @var ShiftUpInSport
     */
    private ShiftUpInSport $shiftUp;
    /**
     * @var StrongKickDownInSport
     */
    private StrongKickDownInSport $strongKickDown;
    /**
     * @var ShiftDownOnKickDownInSport
     */
    private ShiftDownOnKickDownInSport $shiftDownInKickDown;
    /**
     * @var ShiftDownOnStrongKickDownInSport
     */
    private ShiftDownOnStrongKickDownInSport $shiftDownOnStrongKickDown;

    /**
     * Sport constructor.
     * @param AggressivenessInterface $aggressiveness
     * @throws InvalidArgumentException
     */
    public function __construct(AggressivenessInterface $aggressiveness)
    {
        $this->pressed = new PressedSpecification();
        $this->kickDown = new KickDownInSport();
        $this->shiftDown = new ShiftDownInSport($aggressiveness);
        $this->shiftDownOnBreak = new ShiftDownOnBrakeInSport($aggressiveness);
        $this->shiftDownInKickDown = new ShiftDownOnKickDownInSport($aggressiveness);
        $this->shiftUp = new ShiftUpInSport($aggressiveness);
        $this->strongKickDown = new StrongKickDownInSport();
        $this->shiftDownOnStrongKickDown = new ShiftDownOnStrongKickDownInSport($aggressiveness);
    }

    /**
     * @inheritDoc
     */
    public function handle(GasPedal $gas, BreakPedal $break, GearboxInterface $gearbox, ExternalSystemsInterface $externalSystems): void
    {
        if ($this->shouldShiftDownTwoGears($break, $externalSystems->getCurrentRpm())) {
            $gearbox->shiftDown(); //one more time
        }
        parent::handle($gas, $break, $gearbox, $externalSystems);
    }

    /**
     * @inheritDoc
     */
    public function shouldShiftDown(InputState $inputState): bool
    {
        if ($this->strongKickDown->isSatisfiedBy($inputState->getBreak())) {
            return $this->shiftDownOnStrongKickDown->isSatisfiedBy($inputState->getCurrentRpm());
        }

        if ($this->kickDown->isSatisfiedBy($inputState->getBreak())) {
            return $this->shiftDownInKickDown->isSatisfiedBy($inputState->getCurrentRpm());
        }

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

    /**
     * @param BreakPedal $break
     * @param Rpm $currentRpm
     * @return bool
     */
    public function shouldShiftDownTwoGears(BreakPedal $break, Rpm $currentRpm)
    {
        return $this->strongKickDown->isSatisfiedBy($break)
            && $this->shiftDownOnStrongKickDown->isSatisfiedBy($currentRpm);
    }
}