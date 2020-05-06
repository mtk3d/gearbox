<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\ExternalSystems;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Comfort;
use Mtk3d\Gearbox\Gearbox\DrivingMode\DrivingMode;
use Mtk3d\Gearbox\Gearbox\Exception\ActionSequenceException;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\CompletelyPressedSpecification;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

class GearboxDriver
{
    /**
     * @var ExternalSystems
     */
    private ExternalSystems $externalSystems;
    /**
     * @var GearboxInterface
     */
    private GearboxInterface $gearbox;
    /**
     * @var GasPedal
     */
    private GasPedal $gas;
    /**
     * @var BreakPedal
     */
    private BreakPedal $break;
    /**
     * @var DrivingMode
     */
    private DrivingMode $drivingMode;

    /**
     * GearboxDriver constructor.
     * @param GearboxInterface $gearbox
     * @param ExternalSystems $externalSystems
     */
    public function __construct(GearboxInterface $gearbox, ExternalSystems $externalSystems)
    {
        $this->externalSystems = $externalSystems;
        $this->gearbox = $gearbox;
        $this->drivingMode = new Comfort();
    }

    public function handle(GasPedal $gas, BreakPedal $break): void
    {
        $this->break = $break;
        $currentRpm = Rpm::of($this->externalSystems->getCurrentRpm());

        $inputState = InputState::of($gas, $break, $currentRpm);

        $this->drivingMode->handle($inputState, $this->gearbox);
    }

    public function changeDrivingMode(DrivingMode $drivingMode): void
    {
        $this->drivingMode = $drivingMode;
    }

    /**
     * @throws ActionSequenceException
     */
    public function parking(): void
    {
        $this->changeGearMode(GearMode::park());
    }

    /**
     * @throws ActionSequenceException
     */
    public function neutral(): void
    {
        $this->changeGearMode(GearMode::neutral());
    }

    /**
     * @throws ActionSequenceException
     */
    public function drive(): void
    {
        $this->changeGearMode(GearMode::drive());
    }

    /**
     * @throws ActionSequenceException
     */
    public function reverse(): void
    {
        $this->changeGearMode(GearMode::reverse());
    }

    /**
     * @param GearMode $gearMode
     * @throws ActionSequenceException
     */
    private function changeGearMode(GearMode $gearMode): void
    {
        if ($gearMode->equals(GearMode::park()) || $this->gearbox->currentGearModeEquals(GearMode::park())) {
            $completelyPressed = new CompletelyPressedSpecification();
            if ($completelyPressed->isSatisfiedBy($this->break)) {
                throw new ActionSequenceException("Break pedal must be pressed if change to, or from parking mode");
            }
        }

        $this->gearbox->changeGearMode($gearMode);
    }
}