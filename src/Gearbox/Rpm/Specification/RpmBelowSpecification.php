<?php

namespace Mtk3d\Gearbox\Gearbox\Rpm\Specification;

use Mtk3d\Gearbox\Common\Specification;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

class RpmBelowSpecification extends Specification
{
    /**
     * @var Rpm
     */
    private Rpm $rpm;

    /**
     * RpmBelowSpecification constructor.
     * @param Rpm $rpm
     */
    public function __construct(Rpm $rpm)
    {
        $this->rpm = $rpm;
    }

    /**
     * @param Rpm $rpm
     * @return bool
     */
    public function isSatisfiedBy(Rpm $rpm): bool
    {
        return $rpm->value() < $this->rpm->value();
    }
}