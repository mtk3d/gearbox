<?php

namespace Mtk3d\Gearbox\Gearbox\Rpm\Specification\Comfort;

use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\RpmAboveSpecification;

class UpshiftInComfortSpecification extends Specification
{
    /**
     * @var RpmAboveSpecification
     */
    private RpmAboveSpecification $rpmAbove;

    public function __construct()
    {
        $this->rpmAbove =
            new RpmAboveSpecification(Rpm::of(2500));
    }

    public function isSatisfiedBy(Rpm $rpm): bool
    {
        return $this->rpmAbove->isSatisfiedBy($rpm);
    }
}