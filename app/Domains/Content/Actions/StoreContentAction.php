<?php

namespace Domains\Content\Actions;

use Domains\Content\Models\Content;
use Domains\DTOs\ContentData;

class StoreContentAction
{
    public function execute(
        ContentData $data
    ): Content {

        return Content::updateOrCreate(
            [
                'source_id' => $data->sourceId,
                'external_id' => $data->externalId,
            ],
            [
                'title' => $this->sanitizeTitle(
                    $data->title
                ),

                'url' => $data->url,

                'excerpt' => $data->excerpt,

                'content' => $data->content,

                'raw_payload' => $data->rawPayload,

                'published_at' => $data->publishedAt,
            ]
        );
    }

    private function sanitizeTitle(
        ?string $title
    ): string {

        return mb_substr(
            trim($title ?? ''),
            0,
            5000
        );
    }
}
