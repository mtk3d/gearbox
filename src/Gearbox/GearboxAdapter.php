<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Gearbox\Exception\GearOutOfRangeException;

class GearboxAdapter implements GearboxInterface
{
    /**
     * @var Gearbox
     */
    private Gearbox $gearbox;
    /**
     * @var Gear
     */
    private Gear $gear;
    /**
     * @var GearMode
     */
    private GearMode $gearMode;
    /**
     * @var Gear
     */
    private Gear $maxGear;

    /**
     * GearboxAdapter constructor.
     * @param Gearbox $gearbox
     * @param Gear $gear
     * @param GearMode $gearMode
     * @param Gear $maxGear
     */
    public function __construct(
        Gearbox $gearbox,
        Gear $gear,
        GearMode $gearMode,
        Gear $maxGear
    ) {
        $this->gearbox = $gearbox;
        $this->gear = $gear;
        $this->gearMode = $gearMode;
        $this->maxGear = $maxGear;
        $this->updateGearbox();
    }

    /**
     * @param Gear $maxGear
     * @return GearboxAdapter
     * @throws GearOutOfRangeException
     */
    public static function init(Gear $maxGear): GearboxAdapter
    {
        return new GearboxAdapter(
            new Gearbox(),
            Gear::of(1),
            GearMode::neutral(),
            $maxGear
        );
    }

    /**
     * @param GearMode $gearMode
     */
    public function changeGearMode(GearMode $gearMode): void
    {
        $this->gearMode = $gearMode;
        $this->updateGearbox();
    }

    /**
     * @param Gear $gear
     * @throws GearOutOfRangeException
     */
    public function changeGear(Gear $gear): void
    {
        if ($gear->current() > $this->maxGear->current()) {
            throw new GearOutOfRangeException();
        }
        $this->gear = $gear;
        $this->updateGearbox();
    }

    /**
     * @param GearMode $gearMode
     * @return bool
     */
    public function currentGearModeEquals(GearMode $gearMode): bool
    {
        return $this->gearMode->equals($gearMode);
    }

    /**
     * @throws GearOutOfRangeException
     */
    public function shiftDown(): void
    {
        $down = Gear::of($this->gear->current() - 1);
        $this->changeGear($down);
    }

    /**
     * @throws GearOutOfRangeException
     */
    public function shiftUp(): void
    {
        $up = Gear::of($this->gear->current() + 1);
        $this->changeGear($up);
    }

    /**
     * Update target gearbox
     */
    private function updateGearbox(): void
    {
        $this->gearbox->setMaxDrive($this->maxGear->current());
        $this->gearbox->setGearBoxCurrentParams([
            $this->gearMode->getValue(),
            $this->gear->current()
        ]);
    }
}