<?php


namespace Mtk3d\Gearbox\ExternalSystems;

/**
 * Class Gearbox
 *
 * We get this code from our client. Do not touch this!!!
 * All changes should be made in GearboxAdapter
 *
 * @package Mtk3d\Gearbox\Gearbox
 */
class Gearbox
{
    private int $maxDrive;
    private array $gearBoxCurrentParams = [1, 1]; //state, current_gear

    //state 1-Drive, 2-Park, 3-Reverse, 4-Neutral

    public function getState()
    {
        return $this->gearBoxCurrentParams[0];
    }

    public function getCurrentGear()
    {
        return $this->gearBoxCurrentParams[1];
    }

    public function setCurrentGear(int $currentGear) { $this->gearBoxCurrentParams[1] = $currentGear; }

    public function setGearBoxCurrentParams($gearBoxCurrentParams)
    {
        if ($gearBoxCurrentParams[0] != $this->gearBoxCurrentParams[0]) {
            //zmienil sie state
            $this->gearBoxCurrentParams[0] = $gearBoxCurrentParams[0];
            $state = $gearBoxCurrentParams[0];
            if ($state == 2) {
                $this->setCurrentGear(0);
            }
            if ($state == 3) {
                $this->setCurrentGear(-1);
            }
            if ($state == 4) {
                $this->setCurrentGear(0);
            }
        } else {
            $this->setCurrentGear($gearBoxCurrentParams[1]);
        }
    }

    public function getMaxDrive(): int { return $this->maxDrive; }

    public function setMaxDrive(int $maxDrive) { $this->maxDrive = $maxDrive; }
}