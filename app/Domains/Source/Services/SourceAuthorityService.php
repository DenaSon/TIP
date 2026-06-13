<?php

namespace Domains\Source\Services;

use Domains\Source\Models\Source;

class SourceAuthorityService
{
    public function score(
        Source $source
    ): int {

        return $source->authority_score;
    }
}
