<?php


namespace Mtk3d\Gearbox\Gearbox\Pedal\Specification;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\Pedal\Pedal;
use Mtk3d\Gearbox\Gearbox\Pedal\PedalThreshold;

class CompletelyPressedSpecification extends Specification
{
    /**
     * @var PressedAboveSpecification
     */
    private PressedAboveSpecification $pressedAbove;

    /**
     * CompletelyPressedSpecification constructor.
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $this->pressedAbove =
            new PressedAboveSpecification(PedalThreshold::of(0.95));
    }

    /**
     * @param Pedal $pedal
     * @return bool
     */
    public function isSatisfiedBy(Pedal $pedal): bool
    {
        return $this->pressedAbove->isSatisfiedBy($pedal);
    }
}