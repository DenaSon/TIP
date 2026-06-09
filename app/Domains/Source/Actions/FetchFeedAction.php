<?php

namespace Domains\Source\Actions;

use Domains\Source\Models\Source;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FetchFeedAction
{
    /**
     * @throws ConnectionException
     */
    public function execute(Source $source): string
    {
        $url = $source->url;

        if (! $url) {
            throw new RuntimeException(
                "Source [{$source->id}] has no feed URL."
            );
        }

        $response = Http::timeout(20)
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
