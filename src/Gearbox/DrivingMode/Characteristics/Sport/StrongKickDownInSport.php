<?php


namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport;


use Mtk3d\Gearbox\Gearbox\Pedal\Pedal;
use Mtk3d\Gearbox\Gearbox\Pedal\PedalThreshold;
use Mtk3d\Gearbox\Gearbox\Pedal\Specification\PressedAboveSpecification;

class StrongKickDownInSport
{
    /**
     * @var PressedAboveSpecification
     */
    private PressedAboveSpecification $pressedAbove;

    public function __construct()
    {
        $this->pressedAbove =
            new PressedAboveSpecification(PedalThreshold::of(0.9));
    }

    public function isSatisfiedBy(Pedal $pedal): bool
    {
        return $this->pressedAbove->isSatisfiedBy($pedal);
    }
}