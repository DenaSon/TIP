<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\StrategicSignalData;
use Domains\Topic\Data\TopicMetricsData;
use Domains\Topic\Enums\StrategicSignal;

readonly class StrategicSignalService
{
    /**
     * @return StrategicSignalData[]
     */
    public function generate(
        TopicMetricsData $metrics
    ): array {

        $signals = [];

        /*
        |--------------------------------------------------------------------------
        | Rapid Growth
        |--------------------------------------------------------------------------
        */

        if ($metrics->growthRate >= 50) {

            $signals[] =
                new StrategicSignalData(

                    signal: StrategicSignal::RapidGrowth,

                    title: 'Rapid Growth',

                    description: 'Topic growth rate is significantly above normal.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Strong Momentum
        |--------------------------------------------------------------------------
        */

        if ($metrics->momentum >= 50) {

            $signals[] =
                new StrategicSignalData(

                    signal: StrategicSignal::StrongMomentum,

                    title: 'Strong Momentum',

                    description: 'Momentum remains strongly positive.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Strong Authority
        |--------------------------------------------------------------------------
        */

        if ($metrics->authorityScore >= 85) {

            $signals[] =
                new StrategicSignalData(

                    signal: StrategicSignal::StrongAuthority,

                    title: 'Strong Authority',

                    description: 'Trusted sources are actively covering this topic.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Early Opportunity
        |--------------------------------------------------------------------------
        */

        if (
            $metrics->growthRate >= 20
            &&
            $metrics->contentCount < 50
        ) {

            $signals[] =
                new StrategicSignalData(

                    signal: StrategicSignal::EarlyOpportunity,

                    title: 'Early Opportunity',

                    description: 'Growth is accelerating while competition remains low.'
                );
        }

        return $signals;
    }
}
