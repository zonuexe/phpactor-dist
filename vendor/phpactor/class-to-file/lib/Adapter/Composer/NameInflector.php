<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Adapter\Composer;

use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
interface NameInflector
{
    public function inflectToRelativePath(string $prefix, ClassName $className, string $mappedPath) : FilePath;
    public function inflectToClassName(FilePath $filePath, string $pathPrefix, string $classPrefix) : ClassName;
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Adapter\\Composer\\NameInflector', 'Phpactor\\ClassFileConverter\\Adapter\\Composer\\NameInflector', \false);
