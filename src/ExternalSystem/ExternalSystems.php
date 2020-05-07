<?php


namespace Mtk3d\Gearbox\ExternalSystems;


interface ExternalSystems
{
    public function getCurrentRpm(): float;
}