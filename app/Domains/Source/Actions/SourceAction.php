<?php

namespace Domains\Source\Actions;

use Domains\Source\Models\Source;

class SourceAction
{
    public function create(array $data): Source
    {
        return Source::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'status' => $data['status'] ?? Source::STATUS_ACTIVE,
            'config' => $data['config'],
        ]);
    }

    public function update(
        Source $source,
        array $data
    ): Source {
        $source->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'status' => $data['status'],
            'config' => $data['config'],
        ]);

        return $source->fresh();
    }

    public function delete(Source $source): bool
    {
        return (bool) $source->delete();
    }

    public function toggleStatus(Source $source): Source
    {
        $source->toggleStatus();

        return $source->fresh();
    }
}
