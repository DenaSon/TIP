<?php

namespace Domains\Source\Services;

use Domains\DTOs\ContentData;
use Domains\Source\Models\Source;
use Exception;
use SimpleXMLElement;
use Throwable;

class FeedParser
{
    /**
     * @return array<ContentData>
     *
     * @throws Exception
     */
    public function parse(
        Source $source,
        string $xml
    ): array {

        try {

            $feed = new SimpleXMLElement($xml);

            if (isset($feed->channel)) {

                return $this->parseRss(
                    $source,
                    $feed
                );
            }

            if (isset($feed->entry)) {

                return $this->parseAtom(
                    $source,
                    $feed
                );
            }

            logger()->warning(
                'Unsupported feed format',
                [
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                ]
            );

            return [];

        } catch (Throwable $e) {

            logger()->error(
                'Invalid XML feed',
                [
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                    'error' => $e->getMessage(),
                ]
            );

            return [];
        }
    }

    /**
     * @return array<ContentData>
     */
    private function parseRss(
        Source $source,
        SimpleXMLElement $feed
    ): array {

        if (
            ! isset($feed->channel) ||
            ! isset($feed->channel->item)
        ) {

            logger()->warning(
                'Feed contains no entries',
                [
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                ]
            );

            return [];
        }

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
                    .(string) ($item->pubDate ?? '')
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

    /**
     * @return array<ContentData>
     */
    private function parseAtom(
        Source $source,
        SimpleXMLElement $feed
    ): array {

        $items = [];

        foreach ($feed->entry as $entry) {

            $link = '';

            if (isset($entry->link)) {

                $attributes =
                    $entry->link->attributes();

                $link = (string)
                ($attributes['href'] ?? '');
            }

            $externalId = trim(
                (string) ($entry->id ?? '')
            );

            if (blank($externalId)) {

                $externalId = md5(
                    (string) ($entry->title ?? '')
                    .(string) ($entry->updated ?? '')
                );
            }

            $summary = (string)
            ($entry->summary ?? '');

            $content = (string)
            ($entry->content ?? $summary);

            $publishedAt = (string)
            (
                $entry->updated
                ??
                $entry->published
                ??
                ''
            );

            $items[] = new ContentData(
                sourceId: $source->id,

                externalId: $externalId,

                title: (string) ($entry->title ?? ''),

                url: $link,

                excerpt: $summary,

                content: $content,

                rawPayload: json_decode(
                    json_encode($entry),
                    true
                ) ?? [],

                publishedAt: $publishedAt,
            );
        }

        if (empty($items)) {

            logger()->warning(
                'Feed contains no entries',
                [
                    'source_id' => $source->id,
                    'source_name' => $source->name,
                ]
            );
        }

        return $items;
    }
}
