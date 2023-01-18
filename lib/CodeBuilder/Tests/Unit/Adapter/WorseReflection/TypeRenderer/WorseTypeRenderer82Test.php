<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Adapter\WorseReflection\TypeRenderer;

use Generator;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer82;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\FalseType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\StringType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\UnionType;
class WorseTypeRenderer82Test extends TypeRendererTestCase
{
    public function provideType() : Generator
    {
        (yield [new FalseType(), 'false']);
        (yield [new MixedType(), 'mixed']);
        (yield [new StringType(), 'string']);
        (yield [new UnionType(new StringType(), new FalseType()), 'string|false']);
    }
    protected function createRenderer() : WorseTypeRenderer
    {
        return new WorseTypeRenderer82();
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer82Test', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer82Test', \false);
