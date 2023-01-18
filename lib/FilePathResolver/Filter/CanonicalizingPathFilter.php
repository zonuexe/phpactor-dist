<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Filter;

use Phpactor202301\Phpactor\FilePathResolver\Filter;
use Phpactor202301\Symfony\Component\Filesystem\Path;
class CanonicalizingPathFilter implements Filter
{
    public function apply(string $path) : string
    {
        return Path::canonicalize($path);
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Filter\\CanonicalizingPathFilter', 'Phpactor\\FilePathResolver\\Filter\\CanonicalizingPathFilter', \false);
