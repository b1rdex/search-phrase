<?php

declare(strict_types=1);

namespace Search;

use Transliterator;

class FuzzyMatch extends AbstractMatch
{
    private const REPLACE_PAIRS = [
        'a' => '[aа]',
        'b' => '[bьв]',
        'bl' => '(bl|ы)',
        'c' => '[cс]',
        'e' => '[eе]',
        'h' => '[hн]',
        'i' => '[i1l]',
        'k' => '[kк]',
        'l' => '[l1]',
        'm' => '[mмт]',
        'n' => '[nп]',
        'o' => '[oо0]',
        'p' => '[pр]',
        'r' => '[rг]',
        't' => '[tт]',
        'u' => '[uи]',
        'x' => '[xх]',
        'y' => '[yу]',
        'а' => '[аa]',
        'б' => '[б6]',
        'в' => '[вb]',
        'г' => '[гr]',
        'е' => '[еeё]',
        'ё' => '[еeё]',
        'з' => '[з3]',
        'и' => '[иu]',
        'к' => '[кk]',
        'м' => '[мmт]',
        'н' => '[нh]',
        'о' => '[оo0]',
        'п' => '[пn]',
        'р' => '[рp]',
        'с' => '[сc]',
        'т' => '[тtm]',
        'у' => '[уy]',
        'ф' => '[ф]',
        'х' => '[хx]',
        'ч' => '[ч4]',
        'ш' => '[шщ]',
        'щ' => '[шщ]',
        'ъ' => '[ъьb]',
        'ы' => '(ы|bl)',
        'ь' => '[ьb]',
    ];

    public function __construct(string $phrase, ?array $tags = null, ?string $normalized = null)
    {
        $normalized = $normalized ?? $this->normalizeAndPreparePhrase($phrase);

        parent::__construct($phrase, $tags, $normalized);
    }

    private function normalizeAndPreparePhrase(string $phrase): string
    {
        $phrase = $this->normalize($phrase);

        return '/' . \strtr($phrase, self::REPLACE_PAIRS) . '/iu';
    }

    public function normalize(string $text): string
    {
        static $transliterator = null;
        if ($transliterator === null) {
            $transliterator = Transliterator::createFromRules(
                ':: NFD; :: Lower(); :: [^абвгдеёжзиклмнопрстуфъцчшщъыьэюя]-Latin; :: Latin-ASCII; :: [:Nonspacing Mark:] Remove; :: NFC; :: [^[:letter:][:digit:]] Remove;',
                Transliterator::FORWARD
            );
        }

        static $normalized = [];
        if (isset($normalized[$text])) {
            return $normalized[$text];
        }

        return $normalized[$text] = $transliterator->transliterate($text);
    }

    public function matches(string $text): bool
    {
        return \preg_match($this->getNormalized(), $text) === 1;
    }
}
