<?php

declare(strict_types=1);

namespace Search;

class RegexpMatch extends AbstractMatch
{
    public function matches(string $text): bool
    {
        return \preg_match($this->getPhrase(), $text) === 1;
    }
}
