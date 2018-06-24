<?php

declare(strict_types=1);

namespace Search;

interface MatchInterface
{
    public function matches(string $text): bool;
}
