<?php

namespace Phpactor202301\Phpactor\Filesystem\Tests\Unit\Domain;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Filesystem\Domain\FilesystemRegistry;
use Phpactor202301\Phpactor\Filesystem\Domain\Filesystem;
use Phpactor202301\Phpactor\Filesystem\Domain\FallbackFilesystemRegistry;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class FallbackFilesystemRegistryTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy|FilesystemRegistry
     */
    private $innerRegistry;
    private FallbackFilesystemRegistry $registry;
    public function setUp() : void
    {
        $this->innerRegistry = $this->prophesize(FilesystemRegistry::class);
        $this->registry = new FallbackFilesystemRegistry($this->innerRegistry->reveal(), 'bar');
        $this->filesystem1 = $this->prophesize(Filesystem::class);
    }
    public function testDecoration() : void
    {
        $this->innerRegistry->names()->willReturn(['one']);
        $this->innerRegistry->has('foo')->willReturn(\true);
        $this->innerRegistry->get('foo')->willReturn($this->filesystem1->reveal());
        $this->assertEquals(['one'], $this->registry->names());
        $this->assertTrue($this->registry->has('foo'));
        $this->assertSame($this->filesystem1->reveal(), $this->registry->get('foo'));
    }
    public function testFallback() : void
    {
        $this->innerRegistry->has('foo')->willReturn(\false);
        $this->innerRegistry->get('bar')->willReturn($this->filesystem1->reveal());
        $filesystem = $this->registry->get('foo');
        $this->assertSame($this->filesystem1->reveal(), $filesystem);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Tests\\Unit\\Domain\\FallbackFilesystemRegistryTest', 'Phpactor\\Filesystem\\Tests\\Unit\\Domain\\FallbackFilesystemRegistryTest', \false);
