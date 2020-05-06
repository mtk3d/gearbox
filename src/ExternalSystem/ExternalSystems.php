<?php


namespace Mtk3d\Gearbox;


interface ExternalSystems
{
    public function getCurrentRpm(): float;
}