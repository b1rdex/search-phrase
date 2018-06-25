<?php

declare(strict_types=1);

namespace Search\Tests;

use PHPUnit\Framework\TestCase;
use Search\ExactMatch;
use Search\FuzzyMatch;
use Search\RegexpMatch;
use Search\Searcher;
use Search\TextNormalizer;

class SearcherTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_work()
    {
        $normalizer = new TextNormalizer();
        $phrases = [
            new ExactMatch('тест проверки', ['действие 1']),
            new RegexpMatch('/[\d]{11}/i', ['действие 2']),
            new FuzzyMatch('89025211120', ['действие 3']),
            new FuzzyMatch('zergo.ru', ['действие 1', 'действие 2']),
            new FuzzyMatch('Тecm npoBeРku'),
        ];
        $searcher = new Searcher($normalizer, ...$phrases);

        // не находится
        self::assertCount(0, $searcher->search('а были ли тесты проверки?'));
        // подходит под fuzzy с телефоном
        self::assertCount(1, $searcher->search('8(902)521.11-20'));
        // подходит под регулярку и fuzzy с сайтом
        self::assertCount(2, $searcher->search('ищи на сайте zergoru или звони на 12345678901'));
        // подходит под exact и fuzzy(тест проверки)
        self::assertCount(2, $searcher->search('это тест проверки, меня не забанят!'));
        // подходит только под fuzzy(тест проверки), так как умлауты заменяются на латиницу
        self::assertCount(1, $searcher->search('это тęçт прÖвÊркú, меня не забанят!'));
    }
}
