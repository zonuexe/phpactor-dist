<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

interface IndexUpdater
{
    public function build(FileList $fileList) : void;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\IndexUpdater', 'Phpactor\\Indexer\\Model\\IndexUpdater', \false);
