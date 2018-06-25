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

    public function matches(string $text): bool
    {
        return \preg_match($this->preparePhrase(), $text) === 1;
    }

    /**
     * @todo Если думать о производительности, то можно это вынести в конструктор
     * @todo чтобы не выполнять при каждом match()
     *
     * @return string
     */
    private function preparePhrase(): string
    {
        $phrase = \mb_strtolower($this->getPhrase());
        // удаляем всё, кроме букв и цифр из фразы
        $prepared = \preg_replace('/[^[[:alnum:]]/u', '', $phrase);
        $result = '';
        // после каждого символа возможны мусорные символы (не буква и не цифра)
        // todo: можно убрать это и один раз почистить текст при нормализации
        // так должно быть быстрее, но код станет более запутанным
        foreach (\preg_split('//u', $prepared) as $char) {
            if ($char === '') {
                continue;
            }
            $result .= \strtr($char, self::REPLACE_PAIRS) . '[^[:alnum:]]*';
        }

        return '/' . $result . '/iu';
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

        return $transliterator->transliterate($text);
    }
}
