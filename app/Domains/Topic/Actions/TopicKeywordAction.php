<?php

namespace Domains\Topic\Actions;

use App\Domains\Topic\Models\TopicKeyword;
use Domains\Topic\Models\Topic;

class TopicKeywordAction
{
    public function create(
        Topic $topic,
        array $data
    ): TopicKeyword {

        return $topic->keywords()->create([
            'keyword' => $data['keyword'],
            'weight' => $data['weight'],
        ]);
    }

    public function update(
        TopicKeyword $keyword,
        array $data
    ): TopicKeyword {

        $keyword->update([
            'keyword' => $data['keyword'],
            'weight' => $data['weight'],
        ]);

        return $keyword->fresh();
    }

    public function delete(
        TopicKeyword $keyword
    ): bool {

        return (bool) $keyword->delete();
    }
}
