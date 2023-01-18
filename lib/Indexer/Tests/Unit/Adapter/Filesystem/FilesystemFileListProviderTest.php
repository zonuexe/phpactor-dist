<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Adapter\Filesystem;

use Phpactor202301\Phpactor\Filesystem\Adapter\Simple\SimpleFilesystem;
use Phpactor202301\Phpactor\Indexer\Adapter\Filesystem\FilesystemFileListProvider;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\InMemory\InMemoryIndex;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class FilesystemFileListProviderTest extends IntegrationTestCase
{
    use \Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
    private FilesystemFileListProvider $provider;
    private SimpleFilesystem $filesystem;
    /**
     * @var ObjectProphecy<Index>
     */
    private ObjectProphecy $index;
    protected function setUp() : void
    {
        $this->filesystem = new SimpleFilesystem($this->workspace()->path());
        $this->provider = new FilesystemFileListProvider($this->filesystem);
        $this->workspace()->reset();
        $this->index = $this->prophesize(Index::class);
    }
    public function testProvidesSingleFile() : void
    {
        $this->workspace()->put('foo.php', '<?php echo "hello";');
        $index = new InMemoryIndex();
        $list = $this->provider->provideFileList($index, $this->workspace()->path('foo.php'));
        self::assertEquals(1, $list->count());
    }
    public function testProvidesFromFilesystemRoot() : void
    {
        $this->workspace()->put('foo.php', '<?php echo "hello";');
        $this->workspace()->put('bar.php', '<?php echo "hello";');
        $index = new InMemoryIndex();
        $list = $this->provider->provideFileList($index);
        self::assertEquals(2, $list->count());
    }
    public function testDoesNotUseCacheIfSubPathProvided() : void
    {
        $this->workspace()->put('foo.php', '<?php echo "hello";');
        $this->index->isFresh()->shouldNotBeCalled();
        $list = $this->provider->provideFileList($this->index->reveal(), $this->workspace()->path());
        self::assertEquals(1, $list->count());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Adapter\\Filesystem\\FilesystemFileListProviderTest', 'Phpactor\\Indexer\\Tests\\Unit\\Adapter\\Filesystem\\FilesystemFileListProviderTest', \false);
