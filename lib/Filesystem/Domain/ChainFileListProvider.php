<?php

namespace Phpactor202301\Phpactor\Filesystem\Domain;

use AppendIterator;
class ChainFileListProvider implements FileListProvider
{
    /**
     * @var FileListProvider[]
     */
    private array $providers;
    /**
     * @param FileListProvider[] $providers
     */
    public function __construct(array $providers)
    {
        foreach ($providers as $provider) {
            $this->add($provider);
        }
    }
    public function fileList() : FileList
    {
        $iterator = new AppendIterator();
        foreach ($this->providers as $provider) {
            $iterator->append($provider->fileList()->getSplFileInfoIterator());
        }
        return FileList::fromIterator($iterator);
    }
    private function add(FileListProvider $provider) : void
    {
        $this->providers[] = $provider;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Domain\\ChainFileListProvider', 'Phpactor\\Filesystem\\Domain\\ChainFileListProvider', \false);
