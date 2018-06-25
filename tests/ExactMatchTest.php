<?php

declare(strict_types=1);

namespace Search\Tests;

use Search\ExactMatch;
use PHPUnit\Framework\TestCase;

class ExactMatchTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_work(): void
    {
        $exact1 = new ExactMatch('приз');
        self::assertTrue($exact1->matches('сюрприз'));
        self::assertFalse($exact1->matches('сервиз'));
    }
}
