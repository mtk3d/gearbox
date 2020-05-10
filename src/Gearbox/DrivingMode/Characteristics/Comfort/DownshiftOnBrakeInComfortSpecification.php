<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Characteristics\Comfort;

use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\RpmBelowSpecification;

class DownshiftOnBrakeInComfortSpecification extends Specification
{
    /**
     * @var RpmBelowSpecification
     */
    private RpmBelowSpecification $rpmBelow;

    public function __construct()
    {
        $this->rpmBelow =
            new RpmBelowSpecification(Rpm::of(2000));
    }

    public function isSatisfiedBy(Rpm $rpm): bool
    {
        return $this->rpmBelow->isSatisfiedBy($rpm);
    }
}