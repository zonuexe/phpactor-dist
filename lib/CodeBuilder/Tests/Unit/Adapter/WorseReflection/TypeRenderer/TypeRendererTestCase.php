<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Adapter\WorseReflection\TypeRenderer;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
abstract class TypeRendererTestCase extends TestCase
{
    /**
     * @dataProvider provideType
     */
    public function testRender(Type $type, string $expected) : void
    {
        self::assertEquals($expected, $this->createRenderer()->render($type));
    }
    public abstract function provideType() : Generator;
    protected abstract function createRenderer() : WorseTypeRenderer;
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\TypeRendererTestCase', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Adapter\\WorseReflection\\TypeRenderer\\TypeRendererTestCase', \false);
