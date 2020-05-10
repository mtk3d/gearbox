<?php


namespace Mtk3d\Gearbox\ExternalSystems;



class ExternalSystems
{
    private float $currentRpm;
    private float $angularSpeed = 150;
    private Lights $lights;

    public function __construct()
    {
        $this->lights = new Lights();
    }

    /**
     * @return float
     */
    public function getCurrentRpm(): float
    {
        return $this->currentRpm;
    }

    /**
     * @param float $currentRpm
     */
    public function setCurrentRpm(float $currentRpm): void
    {
        $this->currentRpm = $currentRpm;
    }

    /**
     * @return float
     */
    public function getAngularSpeed(): float
    {
        return $this->angularSpeed;
    }

    /**
     * @param float $angularSpeed
     */
    public function setAngularSpeed(float $angularSpeed): void
    {
        $this->angularSpeed = $angularSpeed;
    }

    /**
     * @return Lights
     */
    public function getLights(): Lights
    {
        return $this->lights;
    }

}