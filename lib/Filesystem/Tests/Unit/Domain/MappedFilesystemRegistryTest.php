<?php

namespace Phpactor202301\Phpactor\Filesystem\Tests\Unit\Domain;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Filesystem\Domain\Filesystem;
use Phpactor202301\Phpactor\Filesystem\Domain\MappedFilesystemRegistry;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use InvalidArgumentException;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class MappedFilesystemRegistryTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy<Filesystem>
     */
    private ObjectProphecy $filesystem;
    public function setUp() : void
    {
        $this->filesystem = $this->prophesize(Filesystem::class);
    }
    public function testRetrievesFilesystems() : void
    {
        $registry = $this->createRegistry(['foobar' => $this->filesystem->reveal()]);
        $filesystem = $registry->get('foobar');
        $this->assertEquals($this->filesystem->reveal(), $filesystem);
    }
    public function testHasFilesystem() : void
    {
        $registry = $this->createRegistry(['foobar' => $this->filesystem->reveal()]);
        $this->assertTrue($registry->has('foobar'));
        $this->assertFalse($registry->has('barbar'));
    }
    public function testExceptionOnNotFound() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown filesystem "barfoo"');
        $registry = $this->createRegistry(['foobar' => $this->filesystem->reveal()]);
        $registry->get('barfoo');
    }
    private function createRegistry(array $filesystems)
    {
        return new MappedFilesystemRegistry($filesystems);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Tests\\Unit\\Domain\\MappedFilesystemRegistryTest', 'Phpactor\\Filesystem\\Tests\\Unit\\Domain\\MappedFilesystemRegistryTest', \false);