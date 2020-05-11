<?php

namespace Mtk3d\Gearbox\Gearbox\Rpm;

use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;

class Rpm
{
    /**
     * @var int
     */
    private int $value;

    /**
     * Rpm constructor.
     * @param int $value
     */
    private function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param int $value
     * @return Rpm
     * @throws InvalidArgumentException
     */
    public static function of(int $value): Rpm
    {
        if ($value < 0) {
            throw new InvalidArgumentException("Engine RPM should be above 0");
        }

        return new Rpm($value);
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }
}