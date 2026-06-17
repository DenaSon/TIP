<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicNarrativeData;
use Domains\Topic\Enums\TopicLifecycle;
use Domains\Trend\Models\Trend;

readonly class TopicNarrativeService
{
    public function __construct(
        private TopicLifecycleService $lifecycleService,
        private StrategicSignalService $signalService,
    ) {}

    public function generate(
        Trend $trend
    ): TopicNarrativeData {

        $insights = [];

        $lifecycle =
            $this->lifecycleService
                ->calculate($trend);

        /*
        |--------------------------------------------------------------------------
        | Lifecycle
        |--------------------------------------------------------------------------
        */

        if (
            $lifecycle->lifecycle
            === TopicLifecycle::Emerging
        ) {

            $insights[] =
                'This topic is emerging rapidly.';
        }

        if (
            $lifecycle->lifecycle
            === TopicLifecycle::Growing
        ) {

            $insights[] =
                'This topic continues to gain traction.';
        }

        /*
        |--------------------------------------------------------------------------
        | Signals
        |--------------------------------------------------------------------------
        */

        foreach (
            $this->signalService
                ->generate($trend) as $signal
        ) {

            switch ($signal->signal->value) {

                case 'rapid_growth':

                    $insights[] =
                        'Growth has accelerated significantly.';
                    break;

                case 'strong_momentum':

                    $insights[] =
                        'Momentum remains strongly positive.';
                    break;

                case 'strong_authority':

                    $insights[] =
                        'Trusted sources are actively covering this topic.';
                    break;

                case 'early_opportunity':

                    $insights[] =
                        'Competition remains relatively low.';
                    break;
            }
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
