<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness;


use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

interface AggressivenessInterface
{
    /**
     * @param Rpm $rpm
     * @return Rpm
     */
    public function calculate(Rpm $rpm): Rpm;
}