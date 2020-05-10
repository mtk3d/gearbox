<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness;

use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

class Second implements AggressivenessInterface
{
    public function calculate(Rpm $rpm): Rpm
    {
        return Rpm::of($rpm->value() * 120/100);
    }
}