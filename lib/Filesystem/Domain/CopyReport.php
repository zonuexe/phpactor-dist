<?php

namespace Phpactor202301\Phpactor\Filesystem\Domain;

final class CopyReport
{
    private function __construct(private FileList $srcFiles, private FileList $destFiles)
    {
    }
    public static function fromSrcAndDestFiles(FileList $srcFiles, FileList $destFiles) : CopyReport
    {
        return new self($srcFiles, $destFiles);
    }
    public function srcFiles() : FileList
    {
        return $this->srcFiles;
    }
    public function destFiles() : FileList
    {
        return $this->destFiles;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Domain\\CopyReport', 'Phpactor\\Filesystem\\Domain\\CopyReport', \false);
