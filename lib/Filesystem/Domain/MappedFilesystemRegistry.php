<?php

namespace Phpactor202301\Phpactor\Filesystem\Domain;

use Phpactor202301\Phpactor\Filesystem\Domain\Exception\FilesystemNotFound;
class MappedFilesystemRegistry implements FilesystemRegistry
{
    private $filesystems = [];
    public function __construct(array $filesystemMap)
    {
        foreach ($filesystemMap as $name => $filesystem) {
            $this->add($name, $filesystem);
        }
    }
    public function get(string $name) : Filesystem
    {
        if (!isset($this->filesystems[$name])) {
            throw new FilesystemNotFound(\sprintf('Unknown filesystem "%s", known filesystems "%s"', $name, \implode('", "', \array_keys($this->filesystems))));
        }
        return $this->filesystems[$name];
    }
    public function has(string $name)
    {
        return isset($this->filesystems[$name]);
    }
    public function names() : array
    {
        return \array_keys($this->filesystems);
    }
    private function add(string $name, Filesystem $filesystem) : void
    {
        $this->filesystems[$name] = $filesystem;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Domain\\MappedFilesystemRegistry', 'Phpactor\\Filesystem\\Domain\\MappedFilesystemRegistry', \false);
