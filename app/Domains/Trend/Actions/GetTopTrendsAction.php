<?php
namespace Domains\Trend\Actions;

use Domains\Trend\Models\Trend;
use Illuminate\Support\Collection;

readonly class GetTopTrendsAction
{
    public function execute(): Collection
    {
        return Trend::query()
            ->with('topic')
            ->orderByDesc('score')
            ->get();
    }
}
