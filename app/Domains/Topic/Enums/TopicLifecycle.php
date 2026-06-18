<?php

namespace Domains\Topic\Enums;

enum TopicLifecycle: string
{
    case Emerging = 'emerging';

    case Growing = 'growing';

    case Stable = 'stable';

    case Saturated = 'saturated';

    case Declining = 'declining';

    public function label(): string
    {
        return match ($this) {

            self::Emerging => 'نوظهور',

            self::Growing => 'در حال رشد',

            self::Stable => 'پایدار',

            self::Saturated => 'اشباع شده',

            self::Declining => 'در حال افول',
        };
    }

    public function color(): string
    {
        return match ($this) {

            self::Emerging => 'success',

            self::Growing => 'primary',

            self::Stable => 'info',

            self::Saturated => 'warning',

            self::Declining => 'error',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::Emerging => 'o-sparkles',

            self::Growing => 'o-arrow-trending-up',

            self::Stable => 'o-shield-check',

            self::Saturated => 'o-circle-stack',

            self::Declining => 'o-arrow-trending-down',
        };
    }

    public function description(): string
    {
        return match ($this) {

            self::Emerging => 'موضوع تازه در حال شکل‌گیری است.',

            self::Growing => 'موضوع در حال جذب توجه و رشد است.',

            self::Stable => 'موضوع به بلوغ رسیده و پایدار است.',

            self::Saturated => 'رقابت و پوشش محتوایی بسیار زیاد شده است.',

            self::Declining => 'میزان توجه به موضوع در حال کاهش است.',
        };
    }
}
