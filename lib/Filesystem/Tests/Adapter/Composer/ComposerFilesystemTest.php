<?php

namespace Phpactor202301\Phpactor\Filesystem\Tests\Adapter\Composer;

use Phpactor202301\Phpactor\Filesystem\Adapter\Composer\ComposerFilesystem;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\Filesystem\Tests\Adapter\AdapterTestCase;
use Phpactor202301\Phpactor\Filesystem\Domain\Filesystem;
class ComposerFilesystemTest extends AdapterTestCase
{
    public function setUp() : void
    {
        parent::setUp();
        \chdir($this->workspacePath());
        \exec('composer dumpautoload  2> /dev/null');
    }
    public function testClassmap() : void
    {
        $fileList = $this->filesystem()->fileList();
        $location = $this->filesystem()->createPath('src/Hello/Goodbye.php');
        $fileList = $fileList->named('DB.php');
        $this->assertCount(1, $fileList);
        foreach ($fileList as $file) {
            $this->assertInstanceOf(FilePath::class, $file);
        }
    }
    protected function filesystem() : Filesystem
    {
        static $classLoader;
        if (!$classLoader) {
            $classLoader = (require 'vendor/autoload.php');
        }
        return new ComposerFilesystem(FilePath::fromString($this->workspacePath()), $classLoader);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Tests\\Adapter\\Composer\\ComposerFilesystemTest', 'Phpactor\\Filesystem\\Tests\\Adapter\\Composer\\ComposerFilesystemTest', \false);
