<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicKeywordCandidateData;
use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordQualityGrade;

class TopicKeywordGovernanceScoreService
{
    public function score(
        TopicKeywordCandidateData $candidate
    ): int {

        return match ($candidate->action) {

            KeywordCandidateAction::Promote => $this->scorePromote(
                $candidate
            ),

            KeywordCandidateAction::Keep => $this->scoreKeep(
                $candidate
            ),

            KeywordCandidateAction::ReduceWeight => $this->scoreReduceWeight(
                $candidate
            ),

            KeywordCandidateAction::Remove => $this->scoreRemove(
                $candidate
            ),

            KeywordCandidateAction::NotValidated => $this->scoreNotValidated(
                $candidate
            ),
        };
    }

    private function scorePromote(
        TopicKeywordCandidateData $candidate
    ): int {

        $score = 70;

        if (
            $candidate->qualityGrade
            === KeywordQualityGrade::Excellent
        ) {

            $score += 15;
        }

        if (
            $candidate->matchCount >= 20
        ) {

            $score += 10;
        }

        if (
            $candidate->matchCount >= 50
        ) {

            $score += 5;
        }

        if (
            $candidate->singleKeywordPercentage <= 30
        ) {

            $score += 10;
        }

        return min(
            100,
            $score
        );
    }

    private function scoreKeep(
        TopicKeywordCandidateData $candidate
    ): int {

        $score = 75;

        if (
            $candidate->qualityGrade
            === KeywordQualityGrade::Good
        ) {

            $score += 10;
        }

        if (
            $candidate->matchCount >= 20
        ) {

            $score += 5;
        }

        return min(
            100,
            $score
        );
    }

    private function scoreReduceWeight(
        TopicKeywordCandidateData $candidate
    ): int {

        $score = 50;

        if (
            $candidate->singleKeywordPercentage >= 80
        ) {

            $score += 20;
        }

        if (
            $candidate->qualityGrade
            === KeywordQualityGrade::NeedsReview
        ) {

            $score += 10;
        }

        return min(
            100,
            $score
        );
    }

    private function scoreRemove(
        TopicKeywordCandidateData $candidate
    ): int {

        $score = 40;

        if (
            $candidate->matchCount <= 5
        ) {

            $score += 25;
        }

        if (
            $candidate->matchCount <= 2
        ) {

            $score += 15;
        }

        if (
            $candidate->singleKeywordPercentage >= 90
        ) {

            $score += 15;
        }

        if (
            $candidate->qualityGrade
            === KeywordQualityGrade::Weak
        ) {

            $score += 10;
        }

        return min(
            100,
            $score
        );
    }

    private function scoreNotValidated(
        TopicKeywordCandidateData $candidate
    ): int {

        return 20;
    }
}
