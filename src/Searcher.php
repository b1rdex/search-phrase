<?php

declare(strict_types=1);

namespace Search;

class Searcher
{
    /**
     * @var \Search\TextNormalizer
     */
    private $normalizer;
    /**
     * @var \Search\MatchInterface[]
     */
    private $queries;

    public function __construct(TextNormalizer $normalizer, MatchInterface ...$queries)
    {
        $this->normalizer = $normalizer;
        $this->queries = $queries;
    }

    /**
     * @param string $text
     *
     * @return \Search\MatchInterface[]
     */
    public function search(string $text): array
    {
        // todo: из задания не понял нужно ли по exactMatch и regexpMatch
        // искать в исходном тексте или нормализованном
        // поэтому сделал поиск только по нормализованному
        $normalizedText = $this->normalizer->replaceUmlauts($text);

        $matched = [];
        // todo: в принципе, можно оптимизировать, если из всех $queries собрать одну большую регулярку
        // думаю это будет актуально при количестве $queries больше 1к (нужно тестировать)
        foreach ($this->queries as $query) {
            if ($query->matches($normalizedText)) {
                $matched[] = $query;
            }
        }

        return $matched;
    }
}
