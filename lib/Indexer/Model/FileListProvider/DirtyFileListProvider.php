<?php

namespace Phpactor202301\Phpactor\Indexer\Model\FileListProvider;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\DirtyDocumentTracker;
use Phpactor202301\Phpactor\Indexer\Model\FileList;
use Phpactor202301\Phpactor\Indexer\Model\FileListProvider;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use RuntimeException;
use SplFileInfo;
class DirtyFileListProvider implements FileListProvider, DirtyDocumentTracker
{
    /**
     * @var array<string, bool>
     */
    private array $seen = [];
    public function __construct(private string $dirtyPath)
    {
    }
    public function markDirty(TextDocumentUri $uri) : void
    {
        if (isset($this->seen[$uri->path()])) {
            return;
        }
        $handle = @\fopen($this->dirtyPath, 'a');
        if (\false === $handle) {
            throw new RuntimeException(\sprintf('Dirty index file path "%s" cannot be created, maybe the directory does not exist?', $this->dirtyPath));
        }
        \fwrite($handle, $uri->path() . "\n");
        \fclose($handle);
        $this->seen[$uri->path()] = \true;
    }
    public function provideFileList(Index $index, ?string $subPath = null) : FileList
    {
        return FileList::fromInfoIterator($this->paths());
    }
    /**
     * @return Generator<SplFileInfo>
     */
    private function paths() : Generator
    {
        $contents = @\file_get_contents($this->dirtyPath);
        if (\false === $contents) {
            return;
        }
        $paths = \explode("\n", $contents);
        foreach ($paths as $path) {
            if (!\file_exists($path)) {
                continue;
            }
            (yield new SplFileInfo($path));
        }
        \unlink($this->dirtyPath);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\FileListProvider\\DirtyFileListProvider', 'Phpactor\\Indexer\\Model\\FileListProvider\\DirtyFileListProvider', \false);
