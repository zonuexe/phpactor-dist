<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Core\Inference;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Closure;
use Generator;
abstract class FrameWalkerTestCase extends IntegrationTestCase
{
    /**
     * @dataProvider provideWalk
     */
    public function testWalk(string $source, Closure $assertion) : void
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $path = $this->workspace()->path('test.php');
        $source = SourceCode::fromPathAndString($path, $source);
        $reflector = $this->createReflectorWithWalker($source, $this->walker());
        $reflectionOffset = $reflector->reflectOffset($source, $offset);
        $assertion($reflectionOffset->frame(), $offset);
    }
    public abstract function provideWalk() : Generator;
    public function walker() : ?Framewalker
    {
        return null;
    }
    private function createReflectorWithWalker($source, Walker $frameWalker = null) : Reflector
    {
        $reflector = $this->createBuilder($source);
        if ($frameWalker) {
            $reflector->addFrameWalker($frameWalker);
        }
        return $reflector->build();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Core\\Inference\\FrameWalkerTestCase', 'Phpactor\\WorseReflection\\Tests\\Integration\\Core\\Inference\\FrameWalkerTestCase', \false);
