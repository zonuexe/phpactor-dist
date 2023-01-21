<?php

namespace Phpactor\Filesystem\Domain;

use AppendIterator;
class ChainFileListProvider implements \Phpactor\Filesystem\Domain\FileListProvider
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
    public function fileList() : \Phpactor\Filesystem\Domain\FileList
    {
        $iterator = new AppendIterator();
        foreach ($this->providers as $provider) {
            $iterator->append($provider->fileList()->getSplFileInfoIterator());
        }
        return \Phpactor\Filesystem\Domain\FileList::fromIterator($iterator);
    }
    private function add(\Phpactor\Filesystem\Domain\FileListProvider $provider) : void
    {
        $this->providers[] = $provider;
    }
}
