<?php

namespace Phpactor202301\Phpactor\Filesystem\Domain;

interface FilesystemRegistry
{
    public function get(string $name) : Filesystem;
    public function has(string $name);
    public function names() : array;
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Domain\\FilesystemRegistry', 'Phpactor\\Filesystem\\Domain\\FilesystemRegistry', \false);
