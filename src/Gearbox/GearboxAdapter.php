<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;

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
     * @throws InvalidArgumentException
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
     */
    public function changeGear(Gear $gear): void
    {
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

    public function shiftDown(): void
    {
        $this->gear = $this->gear->shiftDown();
        $this->updateGearbox();
    }

    public function shiftUp(): void
    {
        if ($this->gear->current() >= $this->gearbox->getMaxDrive()) {
            return;
        }
        $this->gear = $this->gear->shiftUp();
        $this->updateGearbox();
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