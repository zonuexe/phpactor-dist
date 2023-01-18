<?php

namespace Phpactor202301\Phpactor\Extension\WorseReflection\Tests\Unit;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FrameResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Variable;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
class TestExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('test.framewalker', function (Container $container) {
            return new TestFrameWalker();
        }, [WorseReflectionExtension::TAG_FRAME_WALKER => []]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflection\\Tests\\Unit\\TestExtension', 'Phpactor\\Extension\\WorseReflection\\Tests\\Unit\\TestExtension', \false);
class TestFrameWalker implements Walker
{
    public function enter(FrameResolver $builder, Frame $frame, Node $node) : Frame
    {
        if ($frame->locals()->byName('test_variable')->count()) {
            return $frame;
        }
        $frame->locals()->set(Variable::fromSymbolContext(NodeContext::for(Symbol::fromTypeNameAndPosition('variable', 'test_variable', Position::fromFullStartStartAndEnd(0, 1, 10)))));
        return $frame;
    }
    public function exit(FrameResolver $builder, Frame $frame, Node $node) : Frame
    {
        return $frame;
    }
    public function nodeFqns() : array
    {
        return [];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflection\\Tests\\Unit\\TestFrameWalker', 'Phpactor\\Extension\\WorseReflection\\Tests\\Unit\\TestFrameWalker', \false);
