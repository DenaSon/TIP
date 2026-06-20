<?php

namespace Domains\Topic\Enums;

enum KeywordCandidateAction: string
{
    case Remove = 'REMOVE';

    case ReduceWeight = 'REDUCE_WEIGHT';

    case Keep = 'KEEP';

    case Promote = 'PROMOTE';

    case NotValidated = 'NOT_VALIDATED';
}
