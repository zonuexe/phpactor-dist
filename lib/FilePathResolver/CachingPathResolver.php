<?php

namespace Phpactor\FilePathResolver;

class CachingPathResolver implements \Phpactor\FilePathResolver\PathResolver
{
    private array $cache = [];
    public function __construct(private \Phpactor\FilePathResolver\PathResolver $innerPathResolver)
    {
    }
    public function resolve(string $path) : string
    {
        if (isset($this->cache[$path])) {
            return $this->cache[$path];
        }
        $this->cache[$path] = $this->innerPathResolver->resolve($path);
        return $this->cache[$path];
    }
}
