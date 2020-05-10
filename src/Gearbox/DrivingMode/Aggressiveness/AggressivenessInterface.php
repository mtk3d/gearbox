<?php


namespace Mtk3d\Gearbox\Gearbox\DrivingMode;


interface AggressivenessInterface
{
    public function calculateAbove();
    public function calculateBelow();
}