<?php

declare(strict_types=1);

namespace Search;

use RuntimeException;

class SearchedDumpLoadFile implements SearcherDumpLoadInterface
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function dump(Searcher $searcher)
    {
        $serial = \serialize($searcher);

        if (!\file_put_contents($this->path, $serial)) {
            throw new RuntimeException('File can\'t be written');
        }

        return $this->path;
    }

    public function load($path): Searcher
    {
        $dump = \file_get_contents($path);
        if (!$dump) {
            throw new RuntimeException('File can\'t be read');
        }

        $object = @\unserialize($dump, [Searcher::class]);
        if ($object === false || !($object instanceof Searcher)) {
            throw new RuntimeException('Corrupted serial content');
        }

        return $object;
    }
}
