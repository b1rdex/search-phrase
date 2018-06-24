<?php

declare(strict_types=1);

namespace Search;

class ExactMatch extends AbstractMatch
{
    public function matches(string $text): bool
    {
        return \stripos($text, $this->getPhrase()) !== false;
    }
}
