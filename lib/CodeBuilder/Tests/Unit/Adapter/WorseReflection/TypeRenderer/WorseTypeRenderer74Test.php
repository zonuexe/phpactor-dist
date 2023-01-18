<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Adapter\WorseReflection\TypeRenderer;

use Generator;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer74;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\CallableType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClosureType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\FalseType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\PseudoIterableType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\StringType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\UnionType;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class WorseTypeRenderer74Test extends TypeRendererTestCase
{
    public function provideType() : Generator
    {
        (yield [new FalseType(), 'bool']);
        (yield [new MixedType(), '']);
        (yield [new StringType(), 'string']);
        (yield [new ClosureType(ReflectorBuilder::create()->build()), 'Closure']);
        (yield [new CallableType(), 'callable']);
        (yield [new PseudoIterableType(), 'iterable']);
        (yield [new UnionType(new StringType(), new FalseType()), '']);
    }
    protected function createRenderer() : WorseTypeRenderer
    {
        return new WorseTypeRenderer74();
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer74Test', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer74Test', \false);
