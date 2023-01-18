<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

interface FileListProvider
{
    public function provideFileList(Index $index, ?string $subPath = null) : FileList;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\FileListProvider', 'Phpactor\\Indexer\\Model\\FileListProvider', \false);
