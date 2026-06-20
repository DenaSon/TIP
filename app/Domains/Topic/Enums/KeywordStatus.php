<?php

namespace Domains\Topic\Enums;

enum KeywordStatus: string
{
    case Active = 'active';

    case Promoted = 'promoted';

    case Deprecated = 'deprecated';

    case Rejected = 'rejected';

    case Draft = 'draft';
}
