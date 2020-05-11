<?php


namespace Mtk3d\Gearbox\ExternalSystems;


class Lights
{
    public int $position;

    /**
     * null - brak opcji w samochodzie
     * 1-3 - w dół
     * 7-10 - w górę
     * @return int
     */
    public function getLightsPosition(): ?int {
        return $this->position;
    }
}