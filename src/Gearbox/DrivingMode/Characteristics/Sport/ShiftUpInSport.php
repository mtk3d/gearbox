<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Sport;

use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness\AggressivenessInterface;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\RpmAboveSpecification;

class ShiftUpInSport extends Specification
{
    /**
     * @var RpmAboveSpecification
     */
    private RpmAboveSpecification $rpmAbove;

    public function __construct(AggressivenessInterface $aggressiveness)
    {
        $rpm = $aggressiveness->calculate(Rpm::of(5000));

        $this->rpmAbove =
            new RpmAboveSpecification($rpm);
    }

    public function isSatisfiedBy(Rpm $rpm): bool
    {
        return $this->rpmAbove->isSatisfiedBy($rpm);
    }
}