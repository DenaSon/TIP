<?php

namespace Domains\Topic\Data;

readonly class TopicProfileData
{
    public function __construct(

        public string $topic,

        public TopicHealthData $health,

        public TopicLifecycleData $lifecycle,

    ) {}

    public function toArray(): array
    {
        return [

            'topic' => $this->topic,

            'health' => $this->health->toArray(),

            'lifecycle' => $this->lifecycle->toArray(),
        ];
    }
}
