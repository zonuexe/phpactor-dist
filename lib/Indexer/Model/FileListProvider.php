<?php

namespace Phpactor\Indexer\Model;

interface FileListProvider
{
    public function provideFileList(\Phpactor\Indexer\Model\Index $index, ?string $subPath = null) : \Phpactor\Indexer\Model\FileList;
}
