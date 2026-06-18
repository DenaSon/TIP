<?php

namespace Domains\Topic\Enums;

enum StrategicSignal: string
{
    case RapidGrowth = 'rapid_growth';

    case StrongMomentum = 'strong_momentum';

    case StrongAuthority = 'strong_authority';

    case EarlyOpportunity = 'early_opportunity';

    public function label(): string
    {
        return match ($this) {

            self::RapidGrowth => 'رشد سریع',

            self::StrongMomentum => 'مومنتوم قوی',

            self::StrongAuthority => 'اعتبار بالا',

            self::EarlyOpportunity => 'فرصت نوظهور',
        };
    }

    public function description(): string
    {
        return match ($this) {

            self::RapidGrowth => 'این موضوع با سرعتی بیشتر از میانگین در حال رشد است.',

            self::StrongMomentum => 'روند رشد این موضوع همچنان قدرتمند و پایدار است.',

            self::StrongAuthority => 'منابع معتبر به شکل فعال این موضوع را پوشش می‌دهند.',

            self::EarlyOpportunity => 'رشد در حال افزایش است اما سطح رقابت هنوز پایین است.',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::RapidGrowth => 'o-arrow-trending-up',

            self::StrongMomentum => 'o-bolt',

            self::StrongAuthority => 'o-shield-check',

            self::EarlyOpportunity => 'o-sparkles',
        };
    }

    public function color(): string
    {
        return match ($this) {

            self::RapidGrowth => 'primary',

            self::StrongMomentum => 'success',

            self::StrongAuthority => 'info',

            self::EarlyOpportunity => 'warning',
        };
    }
}
