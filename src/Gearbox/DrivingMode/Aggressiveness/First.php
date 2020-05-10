<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness;

use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

class First implements AggressivenessInterface
{
    public function calculate(Rpm $rpm): Rpm
    {
        return $rpm;
    }
}