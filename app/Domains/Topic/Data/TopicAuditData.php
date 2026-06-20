<?php


namespace Domains\Topic\Data;

readonly class TopicAuditData
{
    public function __construct(
        public string  $topicName,

        public int     $coverage,

        public int     $sourceDiversity,

        public float   $overlapPercentage,

        public float   $boundaryScore,

        public string  $boundaryStatus,

        public ?string $highestOverlapTopic,

        public float   $highestOverlapPercentage,
    )
    {
    }
}
