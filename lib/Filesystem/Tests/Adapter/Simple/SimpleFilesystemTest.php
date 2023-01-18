<?php

namespace Phpactor202301\Phpactor\Filesystem\Tests\Adapter\Simple;

use Phpactor202301\Phpactor\Filesystem\Adapter\Simple\SimpleFilesystem;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\Filesystem\Tests\Adapter\AdapterTestCase;
use Phpactor202301\Phpactor\Filesystem\Domain\Filesystem;
class SimpleFilesystemTest extends AdapterTestCase
{
    protected function filesystem() : Filesystem
    {
        return new SimpleFilesystem(FilePath::fromString($this->workspacePath()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Tests\\Adapter\\Simple\\SimpleFilesystemTest', 'Phpactor\\Filesystem\\Tests\\Adapter\\Simple\\SimpleFilesystemTest', \false);
