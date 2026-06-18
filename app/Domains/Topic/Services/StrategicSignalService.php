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

            $signal =
                StrategicSignal::RapidGrowth;

            $signals[] =
                new StrategicSignalData(

                    signal: $signal,

                    title: $signal->label(),

                    description: $signal->description(),
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Strong Momentum
        |--------------------------------------------------------------------------
        */

        if ($metrics->momentum >= 50) {

            $signal =
                StrategicSignal::StrongMomentum;

            $signals[] =
                new StrategicSignalData(

                    signal: $signal,

                    title: $signal->label(),

                    description: $signal->description(),
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Strong Authority
        |--------------------------------------------------------------------------
        */

        if ($metrics->authorityScore >= 85) {

            $signal =
                StrategicSignal::StrongAuthority;

            $signals[] =
                new StrategicSignalData(

                    signal: $signal,

                    title: $signal->label(),

                    description: $signal->description(),
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

            $signal =
                StrategicSignal::EarlyOpportunity;

            $signals[] =
                new StrategicSignalData(

                    signal: $signal,

                    title: $signal->label(),

                    description: $signal->description(),
                );
        }

        return $signals;
    }
}
