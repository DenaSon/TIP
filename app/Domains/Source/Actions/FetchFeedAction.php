<?php

namespace Domains\Source\Actions;

use Domains\Source\Models\Source;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FetchFeedAction
{
    public function execute(Source $source): string
    {
        $url = $source->url;

        if (! $url) {
            throw new RuntimeException(
                "Source [{$source->id}] has no feed URL."
            );
        }

        $response = Http::timeout(30)
            ->accept('application/rss+xml')
            ->retry(3)
            ->get($url);

        if (! $response->successful()) {
            throw new RuntimeException(
                "Failed to fetch feed: {$url}"
            );
        }

        return $response->body();
    }
}
