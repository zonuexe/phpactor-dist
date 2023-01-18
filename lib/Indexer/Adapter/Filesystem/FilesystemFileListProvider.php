<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Filesystem;

use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\Filesystem\Domain\Filesystem;
use Phpactor202301\Phpactor\Indexer\Model\FileList;
use Phpactor202301\Phpactor\Indexer\Model\FileListProvider;
use SplFileInfo;
use Phpactor202301\Phpactor\Indexer\Model\Index;
class FilesystemFileListProvider implements FileListProvider
{
    /**
     * @param array<string> $excludePatterns
     * @param array<string> $includePatterns
     */
    public function __construct(private Filesystem $filesystem, private array $includePatterns = [], private array $excludePatterns = [])
    {
    }
    public function provideFileList(Index $index, ?string $subPath = null) : FileList
    {
        if (null !== $subPath && $this->filesystem->exists($subPath) && \is_file($subPath)) {
            return FileList::fromSingleFilePath($subPath);
        }
        $files = $this->filesystem->fileList()->phpFiles();
        if ($this->includePatterns) {
            $files = $files->includePatterns($this->includePatterns);
        }
        if ($this->excludePatterns) {
            $files = $files->excludePatterns($this->excludePatterns);
        }
        if ($subPath) {
            $files = $files->within(FilePath::fromString($subPath));
        }
        if (!$subPath) {
            $files = $files->filter(function (SplFileInfo $fileInfo) use($index) {
                return \false === $index->isFresh($fileInfo);
            });
        }
        return FileList::fromInfoIterator($files->getSplFileInfoIterator());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Filesystem\\FilesystemFileListProvider', 'Phpactor\\Indexer\\Adapter\\Filesystem\\FilesystemFileListProvider', \false);
