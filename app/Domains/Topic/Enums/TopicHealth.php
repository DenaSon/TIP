<?php

namespace Domains\Topic\Enums;

enum TopicHealth: string
{
    case Poor = 'poor';

    case Fair = 'fair';

    case Good = 'good';

    case Excellent = 'excellent';
}
