<?php

namespace Phpactor\Filesystem\Domain;

class FallbackFilesystemRegistry implements \Phpactor\Filesystem\Domain\FilesystemRegistry
{
    public function __construct(private \Phpactor\Filesystem\Domain\FilesystemRegistry $registry, private string $fallback)
    {
    }
    public function get(string $name) : \Phpactor\Filesystem\Domain\Filesystem
    {
        if (\false === $this->registry->has($name)) {
            return $this->registry->get($this->fallback);
        }
        return $this->registry->get($name);
    }
    public function has(string $name)
    {
        return $this->registry->has($name);
    }
    public function names() : array
    {
        return $this->registry->names();
    }
}
