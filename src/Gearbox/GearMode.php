<?php


namespace Mtk3d\Gearbox\Gearbox;

use MyCLabs\Enum\Enum;

/**
 * @method static self drive()
 * @method static self park()
 * @method static self reverse()
 * @method static self neutral()
 *
 * @template-extends Enum<string>
 */
final class GearMode extends Enum
{
    private const drive = '1';
    private const park = '2';
    private const reverse = '3';
    private const neutral = '4';
}