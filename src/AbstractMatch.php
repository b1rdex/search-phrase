<?php

declare(strict_types=1);

namespace Search;

abstract class AbstractMatch implements MatchInterface
{
    /**
     * @var string
     */
    private $phrase;
    /**
     * @var array
     */
    private $tags;

    public function __construct(string $phrase, array $tags = null)
    {
        $this->phrase = $phrase;
        $this->tags = $tags ?? [];
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getPhrase(): string
    {
        return $this->phrase;
    }
}
