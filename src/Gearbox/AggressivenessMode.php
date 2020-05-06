<?php


namespace Mtk3d\Gearbox\Gearbox;

use MyCLabs\Enum\Enum;

/**
 * @method static self first()
 * @method static self second()
 * @method static self third()
 *
 * @template-extends Enum<string>
 */
class AggressivenessMode extends Enum
{
    private const first = '1';
    private const second = '2';
    private const third = '3';
}