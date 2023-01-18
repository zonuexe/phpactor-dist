<?php

namespace Phpactor202301\Phpactor\Extension\ClassMover\Application\Logger;

use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\ClassMover\FoundReferences;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
class NullLogger implements ClassCopyLogger, ClassMoverLogger
{
    public function copying(FilePath $srcPath, FilePath $destPath) : void
    {
    }
    public function replacing(FilePath $path, FoundReferences $references, FullyQualifiedName $replacementName) : void
    {
    }
    public function moving(FilePath $srcPath, FilePath $destPath) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassMover\\Application\\Logger\\NullLogger', 'Phpactor\\Extension\\ClassMover\\Application\\Logger\\NullLogger', \false);
