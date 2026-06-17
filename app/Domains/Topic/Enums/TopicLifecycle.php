<?php

namespace Domains\Topic\Enums;

enum TopicLifecycle: string
{
    case Emerging = 'emerging';

    case Growing = 'growing';

    case Stable = 'stable';

    case Saturated = 'saturated';

    case Declining = 'declining';
}
