<?php

namespace Domains\Topic\Enums;

enum KeywordQualityGrade: string
{
    case NotValidated = 'Not Validated';

    case Weak = 'Weak';

    case NeedsReview = 'Needs Review';

    case Good = 'Good';

    case Excellent = 'Excellent';
}
