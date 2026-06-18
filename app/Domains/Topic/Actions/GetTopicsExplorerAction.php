<?php

namespace Domains\Topic\Actions;

use Domains\Topic\Services\TopicProfileService;
use Domains\Trend\Models\Trend;
use Illuminate\Support\Collection;

readonly class GetTopicsExplorerAction
{
    public function __construct(
        private TopicProfileService $profileService,
    ) {}

    public function execute(): Collection
    {
        return Trend::query()
            ->with('topic')
            ->get()
            ->map(
                fn (Trend $trend) => $this->profileService
                    ->build($trend)
            )
            ->sortByDesc(
                fn ($profile) => $profile->momentum
            )
            ->values();
    }
}
