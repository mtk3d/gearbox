<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness;

class Aggressiveness
{
    public static function first(): AggressivenessInterface
    {
        return new First();
    }

    public static function second(): AggressivenessInterface
    {
        return new Second();
    }

    public static function third(): AggressivenessInterface
    {
        return new Third();
    }
}