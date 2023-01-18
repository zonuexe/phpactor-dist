<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit\Expander\Xdg;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg\XdgCacheExpander;
use Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg\XdgConfigExpander;
use Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg\XdgDataExpander;
use Phpactor202301\Phpactor\FilePathResolver\Expanders;
use Phpactor202301\Phpactor\FilePathResolver\Filter\TokenExpandingFilter;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use Phpactor202301\XdgBaseDir\Xdg;
class XdgExpanderTest extends TestCase
{
    use ProphecyTrait;
    private TokenExpandingFilter $expander;
    /**
     * @var ObjectProphecy<Xdg>
     */
    private ObjectProphecy $xdg;
    public function setUp() : void
    {
        $this->xdg = $this->prophesize(Xdg::class);
        $this->xdg->getHomeDataDir()->willReturn('/home/data');
        $this->xdg->getHomeConfigDir()->willReturn('/home/config');
        $this->xdg->getHomeCacheDir()->willReturn('/home/cache');
        $this->expander = new TokenExpandingFilter(new Expanders([new XdgCacheExpander('cache', $this->xdg->reveal()), new XdgDataExpander('data', $this->xdg->reveal()), new XdgConfigExpander('config', $this->xdg->reveal())]));
    }
    public function testExpandXdgDirs() : void
    {
        $this->assertEquals('/home/cache/foo', $this->expander->apply('%cache%/foo'));
        $this->assertEquals('/home/data/foo', $this->expander->apply('%data%/foo'));
        $this->assertEquals('/home/config/foo', $this->expander->apply('%config%/foo'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\Xdg\\XdgExpanderTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\Xdg\\XdgExpanderTest', \false);
