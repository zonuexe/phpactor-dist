<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Generator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use SplFileInfo;
class IndexJob
{
    public function __construct(private IndexBuilder $indexBuilder, private FileList $fileList)
    {
    }
    /**
     * @return Generator<string>
     */
    public function generator() : Generator
    {
        foreach ($this->fileList as $fileInfo) {
            \assert($fileInfo instanceof SplFileInfo);
            $contents = @\file_get_contents($fileInfo->getPathname());
            if (\false === $contents) {
                continue;
            }
            $this->indexBuilder->index(TextDocumentBuilder::create($contents)->uri($fileInfo->getPathname())->build());
            (yield $fileInfo->getPathname());
        }
        $this->indexBuilder->done();
    }
    public function run() : void
    {
        \iterator_to_array($this->generator());
    }
    public function size() : int
    {
        return $this->fileList->count();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\IndexJob', 'Phpactor\\Indexer\\Model\\IndexJob', \false);
