<?php

namespace Domains\Opportunity\Enums;

enum OpportunityReason: string
{
    case RapidGrowth = 'rapid_growth';

    case PositiveMomentum = 'positive_momentum';

    case StrongAuthority = 'strong_authority';

    case HighOpportunity = 'high_opportunity';

    case StableActivity = 'stable_activity';

    public function title(): string
    {
        return match ($this) {

            self::RapidGrowth => 'رشد سریع',

            self::PositiveMomentum => 'مومنتوم مثبت',

            self::StrongAuthority => 'پوشش منابع معتبر',

            self::HighOpportunity => 'امتیاز فرصت بالا',

            self::StableActivity => 'فعالیت پایدار',
        };
    }

    public function description(): string
    {
        return match ($this) {

            self::RapidGrowth => 'رشد موضوع سهم قابل توجهی در امتیاز فرصت دارد.',

            self::PositiveMomentum => 'شتاب رشد موضوع همچنان مثبت و قدرتمند است.',

            self::StrongAuthority => 'منابع معتبر و اثرگذار این موضوع را پوشش می‌دهند.',

            self::HighOpportunity => 'امتیاز فرصت در سطح بسیار بالایی قرار دارد.',

            self::StableActivity => 'در حال حاضر سیگنال قدرتمندی مشاهده نشده است.',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::RapidGrowth => 'o-arrow-trending-up',

            self::PositiveMomentum => 'o-bolt',

            self::StrongAuthority => 'o-shield-check',

            self::HighOpportunity => 'o-sparkles',

            self::StableActivity => 'o-minus-circle',
        };
    }
}
