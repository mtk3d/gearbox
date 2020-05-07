<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

interface ExternalSystemsInterface
{
    public function getCurrentRpm(): Rpm;
}