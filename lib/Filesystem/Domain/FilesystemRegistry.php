<?php

namespace Phpactor\Filesystem\Domain;

interface FilesystemRegistry
{
    public function get(string $name) : \Phpactor\Filesystem\Domain\Filesystem;
    public function has(string $name);
    public function names() : array;
}
