<?php

declare(strict_types=1);

namespace Search\Test;

use Search\RegexpMatch;
use PHPUnit\Framework\TestCase;

class RegexMatchTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_work()
    {
        $regexp1 = new RegexpMatch('/привет/iu');
        self::assertTrue($regexp1->matches('ПрИвЕтИкИ'));
        self::assertFalse($regexp1->matches('всем в чатике'));
    }
}
