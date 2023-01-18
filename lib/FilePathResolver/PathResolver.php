<?php

namespace Phpactor202301\Phpactor\FilePathResolver;

interface PathResolver
{
    public function resolve(string $path) : string;
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\PathResolver', 'Phpactor\\FilePathResolver\\PathResolver', \false);
