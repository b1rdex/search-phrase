<?php

declare(strict_types=1);

namespace Search;

/**
 * Логика задумана такая, что load(dump($object)) == $object
 */
interface SearcherDumpLoadInterface
{
    /**
     * @param \Search\Searcher $searcher
     *
     * @return mixed
     */
    public function dump(Searcher $searcher);

    /**
     * @param mixed $dump
     *
     * @return \Search\Searcher
     */
    public function load($dump): Searcher;
}
