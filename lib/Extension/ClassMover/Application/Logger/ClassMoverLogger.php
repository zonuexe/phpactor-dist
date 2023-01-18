<?php

namespace Phpactor202301\Phpactor\Extension\ClassMover\Application\Logger;

use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\ClassMover\FoundReferences;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
interface ClassMoverLogger
{
    public function moving(FilePath $srcPath, FilePath $destPath);
    public function replacing(FilePath $path, FoundReferences $references, FullyQualifiedName $replacementName);
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassMover\\Application\\Logger\\ClassMoverLogger', 'Phpactor\\Extension\\ClassMover\\Application\\Logger\\ClassMoverLogger', \false);
