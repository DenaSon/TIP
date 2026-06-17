<?php

namespace Domains\Topic\Data;

use Domains\Topic\Enums\StrategicSignal;

readonly class StrategicSignalData
{
    public function __construct(
        public StrategicSignal $signal,

        public string $title,

        public string $description,
    ) {}

    public function toArray(): array
    {
        return [

            'signal' => $this->signal->value,

            'title' => $this->title,

            'description' => $this->description,
        ];
    }
}
