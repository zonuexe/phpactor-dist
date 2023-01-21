<?php

namespace Phpactor\CodeBuilder\Domain\TemplatePathResolver;

use FilesystemIterator;
class PhpVersionPathResolver
{
    /**
     * @param string $phpVersion
     *      String the form of "major.minor.release[extra]"
     *      @see https://www.php.net/manual/en/reserved.constants.php#reserved.constants.core
     */
    public function __construct(private string $phpVersion)
    {
    }
    public function resolve(iterable $paths) : iterable
    {
        $resolvedPaths = [];
        foreach ($paths as $path) {
            if (!\file_exists($path)) {
                continue;
            }
            $phpDirectoriesIterator = new \Phpactor\CodeBuilder\Domain\TemplatePathResolver\FilterPhpVersionDirectoryIterator(new FilesystemIterator($path), $this->phpVersion);
            $phpDirectories = \array_keys(\iterator_to_array($phpDirectoriesIterator));
            \rsort($phpDirectories, \SORT_NATURAL);
            $resolvedPaths = \array_merge($resolvedPaths, $phpDirectories);
            $resolvedPaths[] = $path;
        }
        return $resolvedPaths;
    }
}
