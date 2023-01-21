<?php

namespace Phpactor\Filesystem\Domain;

interface FileListProvider
{
    public function fileList() : \Phpactor\Filesystem\Domain\FileList;
}
