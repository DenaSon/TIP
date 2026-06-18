<?php

namespace Domains\Topic\Actions;

use Domains\Topic\Services\TopicProfileService;
use Domains\Trend\Models\Trend;

readonly class GetTopicsExplorerAction
{
    public function __construct(
        private TopicProfileService $profileService,
    ) {}

    public function execute()
    {
        return Trend::query()
            ->with('topic')
            ->orderByDesc('score')
            ->get()
            ->map(
                fn (Trend $trend) => $this
                    ->profileService
                    ->build($trend)
            );
    }
}
