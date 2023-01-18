<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\SourceBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class SourceBuilderTest extends TestCase
{
    use \Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
    /**
     * @var ObjectProphecy<Updater>
     */
    private ObjectProphecy $updater;
    private $builder;
    private $generator;
    private $prototype;
    protected function setUp() : void
    {
        $this->generator = $this->prophesize(Renderer::class);
        $this->updater = $this->prophesize(Updater::class);
        $this->builder = new SourceBuilder($this->generator->reveal(), $this->updater->reveal());
        $this->prototype = $this->prophesize(Prototype\Prototype::class);
    }
    /**
     * @testdoc It should delegate to the generator.
     */
    public function testGenerate() : void
    {
        $expectedCode = Code::fromString('');
        $this->generator->render($this->prototype->reveal())->willReturn($expectedCode);
        $code = $this->builder->render($this->prototype->reveal());
        $this->assertSame($expectedCode, $code);
    }
    /**
     * @testdoc It should delegate to the updater.
     */
    public function testUpdate() : void
    {
        $sourceCode = Code::fromString('');
        $this->updater->textEditsFor($this->prototype->reveal(), $sourceCode)->willReturn(TextEdits::none());
        $code = $this->builder->apply($this->prototype->reveal(), $sourceCode);
        $this->assertEquals('', $code);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\SourceBuilderTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\SourceBuilderTest', \false);
