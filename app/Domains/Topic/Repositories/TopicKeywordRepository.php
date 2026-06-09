<?php

namespace App\Domains\Topic\Repositories;

use Domains\Topic\Models\Topic;
use Illuminate\Database\Eloquent\Collection;

class TopicKeywordRepository
{
    public function all(): Collection
    {
        return Topic::query()
            ->select([
                'id',
                'name',
                'slug',
            ])
            ->with([
                'keywords:id,topic_id,keyword,weight',
            ])
            ->get();
    }
}
