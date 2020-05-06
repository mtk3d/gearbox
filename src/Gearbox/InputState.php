<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Gearbox\Pedal\BreakPedal;
use Mtk3d\Gearbox\Gearbox\Pedal\GasPedal;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;

class InputState
{
    /**
     * @var GasPedal
     */
    private GasPedal $gas;
    /**
     * @var BreakPedal
     */
    private BreakPedal $break;
    /**
     * @var Rpm
     */
    private Rpm $currentRpm;

    public function __construct(GasPedal $gas, BreakPedal $break, Rpm $currentRpm)
    {
        $this->gas = $gas;
        $this->break = $break;
        $this->currentRpm = $currentRpm;
    }

    public static function of(GasPedal $gas, BreakPedal $break, Rpm $currentRpm): InputState
    {
        return new InputState($gas, $break, $currentRpm);
    }

    /**
     * @return GasPedal
     */
    public function getGas(): GasPedal
    {
        return $this->gas;
    }

    /**
     * @return BreakPedal
     */
    public function getBreak(): BreakPedal
    {
        return $this->break;
    }

    /**
     * @return Rpm
     */
    public function getCurrentRpm(): Rpm
    {
        return $this->currentRpm;
    }
}