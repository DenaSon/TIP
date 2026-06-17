<?php

namespace Domains\Opportunity\Data;

readonly class OpportunityReasonData
{
    public function __construct(
        public string $code,
        public string $title,
        public string $description,
    ) {}


    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
