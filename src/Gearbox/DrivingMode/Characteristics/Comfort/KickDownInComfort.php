<?php


namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort;


use Mtk3d\Gearbox\Gearbox\Pedal\Pedal;
use Mtk3d\Gearbox\Gearbox\Pedal\PedalThreshold;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\PressedAboveSpecification;

class KickDownInComfort
{
    /**
     * @var PressedAboveSpecification
     */
    private PressedAboveSpecification $pressedAbove;

    public function __construct()
    {
        $this->pressedAbove =
            new PressedAboveSpecification(PedalThreshold::of(0.5));
    }

    public function isSatisfiedBy(Pedal $pedal): bool
    {
        return $this->pressedAbove->isSatisfiedBy($pedal);
    }
}