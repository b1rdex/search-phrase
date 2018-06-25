<?php

declare(strict_types=1);

namespace Search;

interface NormalizeInterface
{
    public function normalize(string $text): string;
}
