<?php


namespace Mtk3d\Gearbox\Gearbox\Pedal\Specification;


use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\Pedal\Pedal;
use Mtk3d\Gearbox\Gearbox\Pedal\PedalThreshold;

class PressedAboveSpecification extends Specification
{
    /**
     * @var PedalThreshold
     */
    private PedalThreshold $threshold;

    public function __construct(PedalThreshold $threshold)
    {
        $this->threshold = $threshold;
    }

    public function isSatisfiedBy(Pedal $pedal): bool
    {
        return $pedal->threshold()->value() > $this->threshold->value();
    }
}