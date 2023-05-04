<?php

namespace Phpactor\Filesystem\Domain;

interface Filesystem
{
    public function fileList() : \Phpactor\Filesystem\Domain\FileList;
    public function move(\Phpactor\Filesystem\Domain\FilePath|string $srcLocation, \Phpactor\Filesystem\Domain\FilePath|string $destLocation) : void;
    public function remove(\Phpactor\Filesystem\Domain\FilePath|string $location) : void;
    public function copy(\Phpactor\Filesystem\Domain\FilePath|string $srcLocation, \Phpactor\Filesystem\Domain\FilePath|string $destLocation) : \Phpactor\Filesystem\Domain\CopyReport;
    public function createPath(string $path) : \Phpactor\Filesystem\Domain\FilePath;
    public function writeContents(\Phpactor\Filesystem\Domain\FilePath|string $path, string $contents) : void;
    public function getContents(\Phpactor\Filesystem\Domain\FilePath|string $path) : string;
    public function exists(\Phpactor\Filesystem\Domain\FilePath|string $path) : bool;
}
