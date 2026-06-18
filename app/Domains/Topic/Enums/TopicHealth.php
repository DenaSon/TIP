<?php

namespace Domains\Topic\Enums;

enum TopicHealth: string
{
    case Poor = 'poor';

    case Fair = 'fair';

    case Good = 'good';

    case Excellent = 'excellent';

    public function label(): string
    {
        return match ($this) {

            self::Poor => 'ضعیف',

            self::Fair => 'متوسط',

            self::Good => 'خوب',

            self::Excellent => 'عالی',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::Poor => 'o-face-frown',

            self::Fair => 'o-face-smile',

            self::Good => 'o-heart',

            self::Excellent => 'o-shield-check',
        };
    }

    public function color(): string
    {
        return match ($this) {

            self::Poor => 'text-error',

            self::Fair => 'text-warning',

            self::Good => 'text-info',

            self::Excellent => 'text-success',
        };
    }
}
