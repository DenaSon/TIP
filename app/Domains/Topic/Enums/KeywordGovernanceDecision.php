<?php

namespace Domains\Topic\Enums;
enum KeywordGovernanceDecision: string
{
    case AutoApprove = 'auto_approve';

    case ManualReview = 'manual_review';

    case Blocked = 'blocked';
}
