<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Adapter\WorseReflection\TypeRenderer;

use Generator;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer81;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\FalseType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IntersectionType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\StringType;
class WorseTypeRenderer81Test extends TypeRendererTestCase
{
    public function provideType() : Generator
    {
        (yield [new FalseType(), 'bool']);
        (yield [new MixedType(), 'mixed']);
        (yield [new StringType(), 'string']);
        (yield [new IntersectionType(new StringType(), new FalseType()), 'string&bool']);
    }
    protected function createRenderer() : WorseTypeRenderer
    {
        return new WorseTypeRenderer81();
        //$this->foobar(file_get_contents('asd'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer81Test', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer81Test', \false);
