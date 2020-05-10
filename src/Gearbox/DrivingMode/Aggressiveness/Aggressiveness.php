<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness;

class Aggressiveness
{
    public static function first(): First
    {
        return new First();
    }

    public static function second(): Second
    {
        return new Second();
    }

    public static function third(): Third
    {
        return new Third();
    }
}