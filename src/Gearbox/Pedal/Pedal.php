<?php


namespace Mtk3d\Gearbox\Gearbox\Pedal;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;

class Pedal
{
    /**
     * @var PedalThreshold
     */
    private PedalThreshold $threshold;

    /**
     * BreakPedal constructor.
     * @param PedalThreshold $threshold
     */
    public function __construct(PedalThreshold $threshold)
    {
        $this->threshold = $threshold;
    }

    /**
     * @param float $threshold
     * @return self
     * @throws InvalidArgumentException
     */
    public static function of(float $threshold): self
    {
        $threshold = PedalThreshold::of($threshold);
        return new static($threshold);
    }

    /**
     * @return PedalThreshold
     */
    public function threshold(): PedalThreshold
    {
        return $this->threshold;
    }
}