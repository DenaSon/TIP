<?php

namespace Domains\Source\Actions;

use Domains\Source\Models\Source;
use Illuminate\Support\Facades\Http;
use Throwable;

class FetchFeedAction
{
    public function execute(Source $source): ?string
    {
        $url = $source->url;

        if (! $url) {

            logger()->warning(
                'Source has no feed url',
                [
                    'source_id' => $source->id,
                ]
            );

            return null;
        }

        try {

            $response = Http::timeout(20)
                ->accept('application/rss+xml')
                ->retry(2, 1000)
                ->get($url);

        } catch (Throwable $e) {

            logger()->warning(
                'Feed fetch failed',
                [
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                    'url' => $url,
                    'error' => $e->getMessage(),
                ]
            );

            return null;
        }

        if (! $response->successful()) {

            logger()->warning(
                'Feed returned non-success status',
                [
                    'source_id' => $source->id,
                    'status' => $response->status(),
                    'url' => $url,
                ]
            );

            return null;
        }

        $contentType = strtolower(
            $response->header('Content-Type') ?? ''
        );

        if (! str_contains($contentType, 'xml')) {

            logger()->warning(
                'Unexpected feed content type',
                [
                    'source_id' => $source->id,
                    'content_type' => $contentType,
                ]
            );
        }

        return $response->body();
    }
}
