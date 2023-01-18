<?php

namespace Phpactor202301\Phpactor\Extension\ClassMover\Application\Logger;

use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ClassMover\FoundReferences;
interface ClassCopyLogger
{
    public function copying(FilePath $srcPath, FilePath $destPath);
    public function replacing(FilePath $path, FoundReferences $references, FullyQualifiedName $replacementName);
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassMover\\Application\\Logger\\ClassCopyLogger', 'Phpactor\\Extension\\ClassMover\\Application\\Logger\\ClassCopyLogger', \false);
