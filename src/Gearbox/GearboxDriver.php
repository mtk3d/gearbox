<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\Aggressiveness;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Comfort;
use Mtk3d\Gearbox\Gearbox\DrivingMode\DrivingMode;
use Mtk3d\Gearbox\Gearbox\Exception\ActionSequenceException;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\CompletelyPressedSpecification;

class GearboxDriver
{
    /**
     * @var ExternalSystemsInterface
     */
    private ExternalSystemsInterface $externalSystems;
    /**
     * @var GearboxInterface
     */
    private GearboxInterface $gearbox;
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
     * @param ExternalSystemsInterface $externalSystems
     * @param DrivingMode $drivingMode
     * @param BreakPedal $break
     */
    public function __construct(
        GearboxInterface $gearbox,
        ExternalSystemsInterface $externalSystems,
        DrivingMode $drivingMode,
        BreakPedal $break
    ) {
        $this->externalSystems = $externalSystems;
        $this->gearbox = $gearbox;
        $this->drivingMode = $drivingMode;
        $this->break = $break;
    }

    /**
     * @param GearboxInterface $gearbox
     * @param ExternalSystemsInterface $externalSystems
     * @return GearboxDriver
     * @throws InvalidArgumentException
     */
    public static function init(
        GearboxInterface $gearbox,
        ExternalSystemsInterface $externalSystems
    ) {
        return new GearboxDriver(
            $gearbox,
            $externalSystems,
            new Comfort(Aggressiveness::first()),
            BreakPedal::of(0)
        );
    }

    /**
     * @param GasPedal $gas
     * @param BreakPedal $break
     */
    public function handle(GasPedal $gas, BreakPedal $break): void
    {
        $this->break = $break;
        $this->drivingMode->handle($gas, $break, $this->gearbox, $this->externalSystems);
    }

    /**
     * @param DrivingMode $drivingMode
     */
    public function changeDrivingMode(DrivingMode $drivingMode): void
    {
        $this->drivingMode = $drivingMode;
    }

    /**
     * @param GearMode $gearMode
     * @throws ActionSequenceException
     * @throws InvalidArgumentException
     */
    public function changeGearMode(GearMode $gearMode): void
    {
        if ($gearMode->equals(GearMode::park()) || $this->gearbox->currentGearModeEquals(GearMode::park())) {
            $completelyPressed = new CompletelyPressedSpecification();
            if (!$completelyPressed->isSatisfiedBy($this->break)) {
                throw new ActionSequenceException("Break pedal must be pressed if change to, or from parking mode");
            }
        }

        $this->gearbox->changeGearMode($gearMode);
    }

    /**
     * @param Gear $newGear
     */
    public function changeGear(Gear $newGear)
    {
        $this->gearbox->changeGear($newGear);
    }
}