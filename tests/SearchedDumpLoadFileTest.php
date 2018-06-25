<?php

declare(strict_types=1);

namespace Search\Tests;

use PHPUnit\Framework\TestCase;
use Search\ExactMatch;
use Search\SearchedDumpLoadFile;
use Search\Searcher;

/**
 * @covers \Search\SearchedDumpLoadFile
 */
class SearchedDumpLoadFileTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_work()
    {
        $sut = new SearchedDumpLoadFile(\tempnam(\sys_get_temp_dir(), 'foobar'));

        $searcher = new Searcher(...[new ExactMatch('test'), new ExactMatch('test 2')]);

        $dump = $sut->dump($searcher);
        $searcher2 = $sut->load($dump);

        \var_dump($searcher, $searcher2);

        self::assertEquals($searcher, $searcher2);
    }
}
