<?php


namespace Mtk3d\Gearbox\Gearbox;


use Mtk3d\Gearbox\Common\Exception\InvalidArgumentException;
use Mtk3d\Gearbox\Gearbox\Rpm\Rpm;
use Mtk3d\Gearbox\ExternalSystems\ExternalSystems;

class ExternalSystemsAdapter implements ExternalSystemsInterface
{
    /**
     * @var ExternalSystems
     */
    private ExternalSystems $externalSystems;

    /**
     * ExternalSystemsAdapter constructor.
     * @param ExternalSystems $externalSystems
     */
    public function __construct(ExternalSystems $externalSystems)
    {
        $this->externalSystems = $externalSystems;
    }

    /**
     * @return Rpm
     * @throws InvalidArgumentException
     */
    public function getCurrentRpm(): Rpm
    {
        return Rpm::of($this->externalSystems->getCurrentRpm());
    }
}