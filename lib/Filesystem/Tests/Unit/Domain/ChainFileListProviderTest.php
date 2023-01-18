<?php

namespace Phpactor202301\Phpactor\Filesystem\Tests\Unit\Domain;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Filesystem\Domain\FileListProvider;
use Phpactor202301\Phpactor\Filesystem\Domain\ChainFileListProvider;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\Filesystem\Domain\FileList;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class ChainFileListProviderTest extends TestCase
{
    use ProphecyTrait;
    public function testChainFileListProvider() : void
    {
        $provider1 = $this->prophesize(FileListProvider::class);
        $provider2 = $this->prophesize(FileListProvider::class);
        $provider1->fileList()->willReturn(FileList::fromFilePaths([FilePath::fromString('/foobar1'), FilePath::fromString('/foobar2')]));
        $provider2->fileList()->willReturn(FileList::fromFilePaths([FilePath::fromString('/foobar3')]));
        $chain = new ChainFileListProvider([$provider1->reveal(), $provider2->reveal()]);
        $fileList = $chain->fileList();
        $this->assertInstanceOf(FileList::class, $fileList);
        $list = \iterator_to_array($fileList);
        $this->assertCount(3, $list);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Tests\\Unit\\Domain\\ChainFileListProviderTest', 'Phpactor\\Filesystem\\Tests\\Unit\\Domain\\ChainFileListProviderTest', \false);
