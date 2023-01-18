<?php

namespace Phpactor202301\Phpactor\Filesystem\Adapter\Composer;

use Phpactor202301\Phpactor\Filesystem\Adapter\Simple\SimpleFilesystem;
use Phpactor202301\Composer\Autoload\ClassLoader;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
class ComposerFilesystem extends SimpleFilesystem
{
    public function __construct($path, ClassLoader $classLoader)
    {
        $path = FilePath::fromUnknown($path);
        parent::__construct($path, new ComposerFileListProvider($path, $classLoader));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Adapter\\Composer\\ComposerFilesystem', 'Phpactor\\Filesystem\\Adapter\\Composer\\ComposerFilesystem', \false);
