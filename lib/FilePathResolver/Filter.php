<?php

namespace Phpactor202301\Phpactor\FilePathResolver;

interface Filter
{
    public function apply(string $path) : string;
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Filter', 'Phpactor\\FilePathResolver\\Filter', \false);
