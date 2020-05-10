<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Eco;

use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\RpmAboveSpecification;

class UpshiftInEcoSpecification extends Specification
{
    /**
     * @var RpmAboveSpecification
     */
    private RpmAboveSpecification $rpmAbove;

    public function __construct()
    {
        $this->rpmAbove =
            new RpmAboveSpecification(Rpm::of(2000));
    }

    public function isSatisfiedBy(Rpm $rpm): bool
    {
        return $this->rpmAbove->isSatisfiedBy($rpm);
    }
}