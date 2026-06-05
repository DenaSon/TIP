<?php

namespace Domains\Trend\Actions;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Throwable;

class CalculateTrendAction
{
    /**
     * @throws Throwable
     */
    public function execute(
        Topic $topic
    ): Trend {

        try {

            $contentsCount = $topic
                ->contents()
                ->count();

            return Trend::updateOrCreate(

                [
                    'topic_id' => $topic->id,
                ],

                [
                    'score' => $contentsCount,

                    'contents_count' => $contentsCount,

                    'calculated_at' => now(),
                ]
            );

        } catch (Throwable $e) {

            logger()->error(
                'Trend calculation failed',
                [
                    'topic_id' => $topic->id,
                    'message' => $e->getMessage(),
                ]
            );

            throw $e;
        }
    }
}
