<?php

namespace Phpactor\Filesystem\Adapter\Composer;

use Phpactor\Filesystem\Adapter\Simple\SimpleFilesystem;
use PhpactorDist\Composer\Autoload\ClassLoader;
use Phpactor\Filesystem\Domain\FilePath;
class ComposerFilesystem extends SimpleFilesystem
{
    public function __construct(FilePath $path, ClassLoader $classLoader)
    {
        parent::__construct($path, new \Phpactor\Filesystem\Adapter\Composer\ComposerFileListProvider($path, $classLoader));
    }
}
