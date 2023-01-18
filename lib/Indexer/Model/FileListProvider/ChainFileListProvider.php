<?php

namespace Phpactor202301\Phpactor\Indexer\Model\FileListProvider;

use Phpactor202301\Phpactor\Indexer\Model\FileList;
use Phpactor202301\Phpactor\Indexer\Model\FileListProvider;
use Phpactor202301\Phpactor\Indexer\Model\Index;
class ChainFileListProvider implements FileListProvider
{
    /**
     * @var array<FileListProvider>
     */
    private array $providers;
    public function __construct(FileListProvider ...$providers)
    {
        $this->providers = $providers;
    }
    public function provideFileList(Index $index, ?string $subPath = null) : FileList
    {
        $fileList = FileList::empty();
        foreach ($this->providers as $provider) {
            $fileList = $fileList->merge($provider->provideFileList($index, $subPath));
        }
        return $fileList;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\FileListProvider\\ChainFileListProvider', 'Phpactor\\Indexer\\Model\\FileListProvider\\ChainFileListProvider', \false);
