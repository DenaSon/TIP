<?php

namespace Domains\Trend\Actions;

use Domains\Trend\Models\Trend;
use Illuminate\Support\Collection;

readonly class GetTopTrendsAction
{
    public function execute(
        int $limit = 9
    ): Collection {

        return Trend::query()
            ->with('topic')
            ->orderByDesc('score')
            ->limit($limit)
            ->get();
    }
}
