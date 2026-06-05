<?php

namespace Domains\Source\Services;

use Domains\DTOs\ContentData;
use Domains\Source\Models\Source;
use Exception;
use SimpleXMLElement;

class FeedParser
{
    /**
     * @return array<ContentData>
     * @throws Exception
     */
    public function parse(
        Source $source,
        string $xml
    ): array {

        $feed = new SimpleXMLElement($xml);

        $items = [];

        foreach ($feed->channel->item as $item) {

            $link = trim(
                (string) ($item->link ?? '')
            );

            $guid = trim(
                (string) ($item->guid ?? '')
            );

            $externalId = $guid ?: $link;

            if (blank($externalId)) {

                $externalId = md5(
                    (string) ($item->title ?? '')
                    . (string) ($item->pubDate ?? '')
                );
            }

            $items[] = new ContentData(
                sourceId: $source->id,

                externalId: $externalId,

                title: (string) ($item->title ?? ''),

                url: $link,

                excerpt: (string) ($item->description ?? ''),

                content: (string) ($item->description ?? ''),

                rawPayload: json_decode(
                json_encode($item),
                true
            ) ?? [],

                publishedAt: (string) ($item->pubDate ?? ''),
            );
        }

        return $items;
    }
}
