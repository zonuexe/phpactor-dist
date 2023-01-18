<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\FilePathResolver\CachingPathResolver;
use Phpactor202301\Phpactor\FilePathResolver\PathResolver;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class CachingPathResolverTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy<PathResolver>
     */
    private ObjectProphecy $resolver;
    public function setUp() : void
    {
        $this->resolver = $this->prophesize(PathResolver::class);
    }
    public function testCachesResult() : void
    {
        $caching = new CachingPathResolver($this->resolver->reveal());
        $this->resolver->resolve('foo')->willReturn('bar')->shouldBeCalledOnce();
        $caching->resolve('foo');
        $caching->resolve('foo');
        $caching->resolve('foo');
        $this->assertEquals('bar', $caching->resolve('foo'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\CachingPathResolverTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\CachingPathResolverTest', \false);
