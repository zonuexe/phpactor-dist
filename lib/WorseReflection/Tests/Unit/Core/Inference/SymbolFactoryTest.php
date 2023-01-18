<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Inference;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
use RuntimeException;
class SymbolFactoryTest extends TestCase
{
    use ProphecyTrait;
    private NodeContextFactory $factory;
    /**
     * @var Node
     */
    private ObjectProphecy $node;
    public function setUp() : void
    {
        $this->factory = new NodeContextFactory();
        $this->node = $this->prophesize(Node::class);
    }
    public function testInformationInvalidKeys() : void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid keys "asd"');
        $this->factory->create('hello', 10, 20, ['asd' => 'asd']);
    }
    public function testInformation() : void
    {
        $information = $this->factory->create('hello', 10, 20);
        $this->assertInstanceOf(NodeContext::class, $information);
        $symbol = $information->symbol();
        $this->assertEquals('hello', $symbol->name());
        $this->assertEquals(10, $symbol->position()->start());
        $this->assertEquals(20, $symbol->position()->end());
    }
    public function testInformationOptions() : void
    {
        $containerType = TypeFactory::fromString('container');
        $type = TypeFactory::fromString('type');
        $information = $this->factory->create('hello', 10, 20, ['symbol_type' => Symbol::ARRAY, 'container_type' => $containerType, 'type' => $type]);
        $this->assertInstanceOf(NodeContext::class, $information);
        $this->assertSame($information->type(), $type);
        $this->assertSame($information->containerType(), $containerType);
        $this->assertEquals(Symbol::ARRAY, $information->symbol()->symbolType());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\SymbolFactoryTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\SymbolFactoryTest', \false);
