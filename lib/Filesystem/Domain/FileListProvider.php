<?php

namespace Phpactor202301\Phpactor\Filesystem\Domain;

interface FileListProvider
{
    public function fileList() : FileList;
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Domain\\FileListProvider', 'Phpactor\\Filesystem\\Domain\\FileListProvider', \false);
