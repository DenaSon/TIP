<?php

namespace Domains\Trend\Services;

class MomentumService
{
    public function calculate(
        float $growthRate,
        float $velocity
    ): float {

        return round(

            ($growthRate * 0.7)

            +

            (max($velocity, 0) * 0.3),

            2
        );
    }
}
