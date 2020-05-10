<?php

namespace Mtk3d\Gearbox\Gearbox\DrivingMode\Aggressiveness;

class Aggressiveness
{
    /**
     * @return First
     */
    public static function first(): First
    {
        return new First();
    }

    /**
     * @return Second
     */
    public static function second(): Second
    {
        return new Second();
    }

    /**
     * @return Third
     */
    public static function third(): Third
    {
        return new Third();
    }
}