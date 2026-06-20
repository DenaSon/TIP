<?php

namespace Domains\Topic\Services;

use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordStatus;
use Domains\Topic\Models\Topic;
use Domains\Topic\Models\TopicKeyword;
use Illuminate\Support\Facades\DB;

readonly class TopicKeywordApplyService
{
    private const int MIN_WEIGHT = 50;

    private const int WEIGHT_DECREMENT = 5;

    public function __construct(
        private TopicKeywordGovernanceService $governanceService,
    ) {}

    /**
     * @throws \Throwable
     */
    public function apply(
        Topic $topic
    ): int {

        $governanceItems =
            $this->governanceService
                ->analyze($topic);

        $affected = 0;

        DB::transaction(
            function () use (
                $governanceItems,
                &$affected
            ) {

                foreach (
                    $governanceItems as $item
                ) {

                    if (
                        ! $item->autoApplicable
                    ) {
                        continue;
                    }

                    $keyword =
                        TopicKeyword::query()
                            ->find(
                                $item->keywordId
                            );

                    if (! $keyword) {
                        continue;
                    }

                    $changed =
                        match ($item->action) {

                            KeywordCandidateAction::Promote => $this->applyPromote(
                                $keyword
                            ),

                            KeywordCandidateAction::ReduceWeight => $this->applyReduceWeight(
                                $keyword
                            ),

                            KeywordCandidateAction::Remove => $this->applyRemove(
                                $keyword
                            ),

                            KeywordCandidateAction::NotValidated => $this->applyDraft(
                                $keyword
                            ),

                            KeywordCandidateAction::Keep => false,
                        };

                    if ($changed) {
                        $affected++;
                    }
                }
            }
        );

        return $affected;
    }

    private function applyPromote(
        TopicKeyword $keyword
    ): bool {

        if (
            $keyword->status
            === KeywordStatus::Promoted
        ) {
            return false;
        }

        $keyword->update([

            'status' => KeywordStatus::Promoted,
        ]);

        return true;
    }

    private function applyReduceWeight(
        TopicKeyword $keyword
    ): bool {

        $newWeight =
            max(
                self::MIN_WEIGHT,
                $keyword->weight
                - self::WEIGHT_DECREMENT
            );

        if (
            $newWeight === $keyword->weight
            &&
            $keyword->status
            === KeywordStatus::Deprecated
        ) {
            return false;
        }

        $keyword->update([

            'weight' => $newWeight,

            'status' => KeywordStatus::Deprecated,
        ]);

        return true;
    }

    private function applyRemove(
        TopicKeyword $keyword
    ): bool {

        if (
            $keyword->status
            === KeywordStatus::Rejected
        ) {
            return false;
        }

        $keyword->update([

            'status' => KeywordStatus::Rejected,
        ]);

        return true;
    }

    private function applyDraft(
        TopicKeyword $keyword
    ): bool {

        if (
            $keyword->status
            === KeywordStatus::Draft
        ) {
            return false;
        }

        $keyword->update([

            'status' => KeywordStatus::Draft,
        ]);

        return true;
    }
}
