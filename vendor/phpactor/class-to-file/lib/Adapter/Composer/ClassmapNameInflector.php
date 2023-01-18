<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Adapter\Composer;

use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
final class ClassmapNameInflector implements NameInflector
{
    public function inflectToRelativePath(string $prefix, ClassName $className, string $mappedPath) : FilePath
    {
        return FilePath::fromString($mappedPath);
    }
    public function inflectToClassName(FilePath $filePath, string $pathPrefix, string $classPrefix) : ClassName
    {
        return ClassName::fromString($classPrefix);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Adapter\\Composer\\ClassmapNameInflector', 'Phpactor\\ClassFileConverter\\Adapter\\Composer\\ClassmapNameInflector', \false);
