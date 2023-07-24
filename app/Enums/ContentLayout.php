<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ContentLayout extends Enum
{
    const LeftImageRightText = 0;
    const LeftTextRightImage = 1;
    const TextOnly = 2;
    const ImageOnly = 3;
}
