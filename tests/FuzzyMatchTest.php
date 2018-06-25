<?php

declare(strict_types=1);

namespace Search\Tests;

use Search\FuzzyMatch;
use PHPUnit\Framework\TestCase;

class FuzzyMatchTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_work(): void
    {
        $fuzzy1 = new FuzzyMatch('просто фраза');
        self::assertTrue($fuzzy1->matches('нe прост0 фраза, а обман'));
        self::assertFalse($fuzzy1->matches('просто азаза'));

        // todo: думаю имеет смысл для поиска телефонов и доменов сделать отдельный класс, который будет
        // более специфичен. Например, для телефонов стоит проверять замены 8 на +7
        // а для доменов вместо . могут писать всякие точка, dot
        $fuzzy2 = new FuzzyMatch('mail.ru');
        self::assertTrue($fuzzy2->matches('_m_a_i_l.r_u'));

        $fuzzy3 = new FuzzyMatch('89025211120');
        self::assertTrue($fuzzy3->matches('8(902)521-11-20'));
    }

    /**
     * @test
     */
    public function it_should_normalize()
    {
        $sut = new FuzzyMatch('');
        $symbols = 'ąčęėįšųūžŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿатак езда рулям?её';
        $normalized = $sut->normalize($symbols);
        echo $normalized;
        self::assertNotSame($symbols, $normalized);
    }
}
