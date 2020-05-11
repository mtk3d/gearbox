<?php


namespace Mtk3d\Gearbox\Gearbox\Pedal;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;

class PedalThreshold
{
    /**
     * @var float
     */
    private float $value;

    /**
     * PedalThreshold constructor.
     * @param float $value
     */
    private function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @param float $threshold
     * @return PedalThreshold
     * @throws InvalidArgumentException
     */
    public static function of(float $threshold): PedalThreshold
    {
        if ($threshold < 0 || $threshold > 1) {
            throw new InvalidArgumentException("Pedal threshold should be in range between 0 and 1");
        }

        return new PedalThreshold($threshold);
    }

    /**
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }
}