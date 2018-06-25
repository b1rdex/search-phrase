<?php

declare(strict_types=1);

namespace Search\Tests;

use Search\TextNormalizer;
use PHPUnit\Framework\TestCase;

class TextNormalizerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_replace_umlauts()
    {
        $sut = new TextNormalizer();
        $umlauts = 'ąčęėįšųūžŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿатак езда рулям?её';
        $result = $sut->replaceUmlauts($umlauts);

        die($result);
    }
}
