<?php

namespace Phpactor\Indexer\Model;

interface IndexUpdater
{
    public function build(\Phpactor\Indexer\Model\FileList $fileList) : void;
}
