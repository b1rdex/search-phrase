<?php

declare(strict_types=1);

namespace Search;

abstract class AbstractMatch implements MatchInterface, NormalizeInterface
{
    /**
     * @var string
     */
    private $phrase;
    /**
     * @var array
     */
    private $tags;
    /**
     * @var string
     */
    private $normalized;

    /**
     * AbstractMatch constructor.
     *
     * @param string      $phrase
     * @param array|null  $tags
     * @param null|string $normalized вынесено как параметр для возможности кэширования
     */
    public function __construct(string $phrase, array $tags = null, ?string $normalized = null)
    {
        $this->phrase = $phrase;
        $this->tags = $tags ?? [];
        $this->normalized = $normalized ?? $this->normalize($phrase);
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getPhrase(): string
    {
        return $this->phrase;
    }

    public function getNormalized(): string
    {
        return $this->normalized;
    }
}
