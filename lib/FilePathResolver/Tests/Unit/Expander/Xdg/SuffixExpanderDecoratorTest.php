<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit\Expander\Xdg;

use Phpactor202301\Phpactor\FilePathResolver\Expander;
use Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg\SuffixExpanderDecorator;
use Phpactor202301\Phpactor\FilePathResolver\Tests\Unit\Expander\ExpanderTestCase;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class SuffixExpanderDecoratorTest extends ExpanderTestCase
{
    use ProphecyTrait;
    /**
     * @var ObjectProphecy<Expander>
     */
    private ObjectProphecy $expander;
    public function setUp() : void
    {
        $this->expander = $this->prophesize(Expander::class);
    }
    public function createExpander() : Expander
    {
        return new SuffixExpanderDecorator($this->expander->reveal(), '/foo');
    }
    public function testAddsSuffixToInnerExpanderValue() : void
    {
        $this->expander->tokenName()->willReturn('bar');
        $this->expander->replacementValue()->willReturn('bar');
        $this->assertEquals('/bar/foo', $this->expand('/%bar%'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\Xdg\\SuffixExpanderDecoratorTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\Expander\\Xdg\\SuffixExpanderDecoratorTest', \false);
