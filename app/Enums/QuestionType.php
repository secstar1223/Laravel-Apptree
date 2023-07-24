<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuestionType extends Enum
{
    const MultipleChoice = 0;
    const Ai = 1;
    const TrueFalse = 2;
    const FillBlanks = 3;
    const LikertScale = 4;
}
