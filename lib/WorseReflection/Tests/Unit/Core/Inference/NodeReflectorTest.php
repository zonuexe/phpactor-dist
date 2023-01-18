<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Inference;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\CouldNotResolveNode;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class NodeReflectorTest extends TestCase
{
    use ProphecyTrait;
    public function testUnkown() : void
    {
        $this->expectException(CouldNotResolveNode::class);
        $this->expectExceptionMessage('Did not know how');
        $frame = new Frame('test');
        $locator = $this->prophesize(ServiceLocator::class);
        $nodeReflector = new NodeReflector($locator->reveal());
        $nodeReflector->reflectNode($frame, new SourceFileNode());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\NodeReflectorTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Inference\\NodeReflectorTest', \false);
