<?php

namespace Mtk3d\Gearbox\Gearbox\Rpm\Specification\Sport;

use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use Mtk3d\Gearbox\Gearbox\Rpm\Specification\RpmAboveSpecification;

class UpshiftOnKickdownInSportSpecification extends Specification
{
    /**
     * @var RpmAboveSpecification
     */
    private RpmAboveSpecification $rpmAbove;

    public function __construct()
    {
        $this->rpmAbove =
            new RpmAboveSpecification(Rpm::of(5000));
    }

    public function isSatisfiedBy(Rpm $rpm): bool
    {
        return $this->rpmAbove->isSatisfiedBy($rpm);
    }
}