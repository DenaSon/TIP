<?php

namespace Domains\Topic\Actions;

use Domains\Topic\Models\Topic;
use Illuminate\Support\Str;

class TopicAction
{
    public function create(array $data): Topic
    {
        return Topic::query()->create([
            'name' => $data['name'],
            'slug' => $data['slug']
                ?? Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function update(
        Topic $topic,
        array $data
    ): Topic {

        $topic->update([
            'name' => $data['name'],
            'slug' => $data['slug']
                ?? Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'],
        ]);

        return $topic->fresh();
    }

    public function delete(
        Topic $topic
    ): bool {

        return (bool) $topic->delete();
    }

    public function toggle(
        Topic $topic
    ): Topic {

        $topic->update([
            'is_active' => ! $topic->is_active,
        ]);

        return $topic->fresh();
    }
}
