<?php

namespace Phpactor202301\Phpactor\FilePathResolver;

class CachingPathResolver implements PathResolver
{
    private array $cache = [];
    public function __construct(private PathResolver $innerPathResolver)
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
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\CachingPathResolver', 'Phpactor\\FilePathResolver\\CachingPathResolver', \false);
