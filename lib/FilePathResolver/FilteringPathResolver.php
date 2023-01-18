<?php

namespace Phpactor202301\Phpactor\FilePathResolver;

class FilteringPathResolver implements PathResolver
{
    /**
     * @param \Phpactor\FilePathResolver\Filter[] $filters
     */
    public function __construct(private array $filters = [])
    {
    }
    public function resolve(string $path) : string
    {
        foreach ($this->filters as $filter) {
            $path = $filter->apply($path);
        }
        return $path;
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\FilteringPathResolver', 'Phpactor\\FilePathResolver\\FilteringPathResolver', \false);
