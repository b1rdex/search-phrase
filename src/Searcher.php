<?php

declare(strict_types=1);

namespace Search;

class Searcher
{
    /**
     * @var \Search\MatchInterface[]
     */
    private $queries;

    public function __construct(MatchInterface ...$queries)
    {
        $this->queries = $queries;
    }

    /**
     * @param string $text
     *
     * @return \Search\MatchInterface[]
     */
    public function search(string $text): array
    {
        $matched = [];
        foreach ($this->queries as $query) {
            $preparedText = $text;
            if ($query instanceof NormalizeInterface) {
                $preparedText = $query->normalize($text);
            }
            if ($query->matches($preparedText)) {
                $matched[] = $query;
            }
        }

        return $matched;
    }
}
