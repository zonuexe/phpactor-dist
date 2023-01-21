<?php

namespace Phpactor\Filesystem\Domain;

final class CopyReport
{
    private function __construct(private \Phpactor\Filesystem\Domain\FileList $srcFiles, private \Phpactor\Filesystem\Domain\FileList $destFiles)
    {
    }
    public static function fromSrcAndDestFiles(\Phpactor\Filesystem\Domain\FileList $srcFiles, \Phpactor\Filesystem\Domain\FileList $destFiles) : \Phpactor\Filesystem\Domain\CopyReport
    {
        return new self($srcFiles, $destFiles);
    }
    public function srcFiles() : \Phpactor\Filesystem\Domain\FileList
    {
        return $this->srcFiles;
    }
    public function destFiles() : \Phpactor\Filesystem\Domain\FileList
    {
        return $this->destFiles;
    }
}
