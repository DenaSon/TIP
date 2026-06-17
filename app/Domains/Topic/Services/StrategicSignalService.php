<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\StrategicSignalData;
use Domains\Topic\Enums\StrategicSignal;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\MomentumService;

readonly class StrategicSignalService
{
    public function __construct(
        private MomentumService $momentumService,
    ) {}

    /**
     * @return StrategicSignalData[]
     */
    public function generate(
        Trend $trend
    ): array {

        $signals = [];

        $topic =
            $trend->topic;

        $contentCount =
            $topic
                ->contents()
                ->count();

        $momentum =
            $this->momentumService
                ->calculate(
                    $trend->growth_rate,
                    $trend->velocity
                );

        /*
        |--------------------------------------------------------------------------
        | Rapid Growth
        |--------------------------------------------------------------------------
        */

        if ($trend->growth_rate >= 50) {

            $signals[] =
                new StrategicSignalData(

                    signal:
                    StrategicSignal::RapidGrowth,

                    title:
                    'Rapid Growth',

                    description:
                    'Topic growth rate is significantly above normal.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Strong Momentum
        |--------------------------------------------------------------------------
        */

        if ($momentum >= 50) {

            $signals[] =
                new StrategicSignalData(

                    signal:
                    StrategicSignal::StrongMomentum,

                    title:
                    'Strong Momentum',

                    description:
                    'Momentum remains strongly positive.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Strong Authority
        |--------------------------------------------------------------------------
        */

        if ($trend->authority_score >= 85) {

            $signals[] =
                new StrategicSignalData(

                    signal:
                    StrategicSignal::StrongAuthority,

                    title:
                    'Strong Authority',

                    description:
                    'Trusted sources are actively covering this topic.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Early Opportunity
        |--------------------------------------------------------------------------
        */

        if (
            $trend->growth_rate >= 20
            &&
            $contentCount < 50
        ) {

            $signals[] =
                new StrategicSignalData(

                    signal:
                    StrategicSignal::EarlyOpportunity,

                    title:
                    'Early Opportunity',

                    description:
                    'Growth is accelerating while competition remains low.'
                );
        }

        return $signals;
    }
}
