<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\Exception\GearOutOfRangeException;

class Gear
{
    /**
     * @var int
     */
    private int $gear;

    /**
     * Gear constructor.
     * @param int $gear
     */
    private function __construct(int $gear)
    {
        $this->gear = $gear;
    }

    /**
     * @param int $gear
     * @return Gear
     * @throws GearOutOfRangeException
     */
    public static function of(int $gear): Gear
    {
        if ($gear < 1) {
            throw new GearOutOfRangeException("Gear number shouldn't be less than 1");
        }

        return new Gear($gear);
    }

    /**
     * @return int
     */
    public function current(): int
    {
        return $this->gear;
    }
}