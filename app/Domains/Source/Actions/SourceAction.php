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
            'authority_score' => $data['authority_score'],
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
            'authority_score' => $data['authority_score'],
            'config' => $data['config'],
        ]);

        return $source->fresh();
    }

    public function delete(Source $source): bool
    {
        return (bool) $source->delete();
    }

    public function restore(Source $source): Source
    {
        $source->restore();

        return $source->fresh();
    }

    public function toggleStatus(Source $source): Source
    {
        $source->toggleStatus();

        return $source->fresh();
    }
}
