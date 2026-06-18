<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicMetricsData;
use Domains\Topic\Data\TopicNarrativeData;
use Domains\Topic\Enums\StrategicSignal;
use Domains\Topic\Enums\TopicLifecycle;

readonly class TopicNarrativeService
{
    public function __construct(
        private TopicLifecycleService $lifecycleService,
        private StrategicSignalService $signalService,
    ) {}

    public function generate(
        TopicMetricsData $metrics
    ): TopicNarrativeData {

        $insights = [];

        $lifecycle =
            $this->lifecycleService
                ->calculate($metrics);

        /*
        |--------------------------------------------------------------------------
        | Lifecycle Narrative
        |--------------------------------------------------------------------------
        */

        match ($lifecycle->lifecycle) {

            TopicLifecycle::Emerging
            => $insights[] =
                'این موضوع با سرعت در حال ظهور است.',

            TopicLifecycle::Growing
            => $insights[] =
                'این موضوع همچنان در حال جذب توجه و رشد است.',

            TopicLifecycle::Stable
            => $insights[] =
                'این موضوع به مرحله پایداری رسیده است.',

            TopicLifecycle::Saturated
            => $insights[] =
                'رشد موضوع به مرحله اشباع نزدیک شده است.',

            TopicLifecycle::Declining
            => $insights[] =
                'توجه به این موضوع در حال کاهش است.',
        };

        /*
        |--------------------------------------------------------------------------
        | Signal Narrative
        |--------------------------------------------------------------------------
        */

        foreach (
            $this->signalService
                ->generate($metrics)
            as $signal
        ) {

            match ($signal->signal) {

                StrategicSignal::RapidGrowth
                => $insights[] =
                    'سرعت رشد این موضوع به شکل محسوسی افزایش یافته است.',

                StrategicSignal::StrongMomentum
                => $insights[] =
                    'مومنتوم رشد همچنان قدرتمند و مثبت باقی مانده است.',

                StrategicSignal::StrongAuthority
                => $insights[] =
                    'منابع معتبر و اثرگذار به صورت فعال این موضوع را پوشش می‌دهند.',

                StrategicSignal::EarlyOpportunity
                => $insights[] =
                    'با وجود رشد مناسب، سطح رقابت هنوز پایین است.',
            };
        }

        $summary =
            implode(
                ' ',
                $insights
            );

        return new TopicNarrativeData(
            summary: $summary,
            insights: $insights,
        );
    }
}
