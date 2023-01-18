<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\FilePathResolver\Filter;
use Phpactor202301\Phpactor\FilePathResolver\FilteringPathResolver;
use Phpactor202301\Phpactor\FilePathResolver\PathResolver;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class FilteringPathResolverTest extends TestCase
{
    use ProphecyTrait;
    public function testIdentity() : void
    {
        $resolver = new FilteringPathResolver();
        $this->assertInstanceOf(PathResolver::class, $resolver);
        $this->assertEquals('/foo/bar', $resolver->resolve('/foo/bar'));
    }
    public function testAppliesFilters() : void
    {
        $filter1 = $this->prophesize(Filter::class);
        $filter2 = $this->prophesize(Filter::class);
        $filter1->apply('foo')->willReturn('bar');
        $filter2->apply('bar')->willReturn('baz');
        $resolver = new FilteringPathResolver([$filter1->reveal(), $filter2->reveal()]);
        $this->assertEquals('baz', $resolver->resolve('foo'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\FilteringPathResolverTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\FilteringPathResolverTest', \false);
