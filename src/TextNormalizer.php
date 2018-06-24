<?php

declare(strict_types=1);

namespace Search;

class TextNormalizer
{
    public function replaceUmlauts(string $string): string
    {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        if (strpos($string, '&') !== false) {
            $replaced = preg_replace(
                '/&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml|caron);/i',
                '$1',
                $string
            );
            $string = html_entity_decode($replaced, ENT_QUOTES, 'UTF-8');
        }

        setlocale(LC_ALL, 'en_US');
        $cp1251 = iconv('utf-8', 'windows-1251//TRANSLIT//IGNORE', $string);

        return iconv('windows-1251', 'utf-8', $cp1251);
    }
}
