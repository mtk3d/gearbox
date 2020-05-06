<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;

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
     * @throws InvalidArgumentException
     */
    public static function of(int $gear): Gear
    {
        if ($gear < 1) {
            throw new InvalidArgumentException("Gear number shouldn't be less than 1");
        }

        return new Gear($gear);
    }

    /**
     * @param int $gear
     * @return Gear
     * @throws InvalidArgumentException
     */
    public function change(int $gear): Gear
    {
        return Gear::of($gear);
    }

    /**
     * @return int
     */
    public function current(): int
    {
        return $this->gear;
    }

    public function shiftDown(): Gear
    {
        try {
            $gear = Gear::of($this->current() - 1);
        } catch (InvalidArgumentException $e) {
            return $this;
        }
        return $gear;
    }

    public function shiftUp(): Gear
    {
        return Gear::of($this->current() + 1);
    }
}