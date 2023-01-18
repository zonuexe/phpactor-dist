<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Type;

use Generator;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayShapeType;
class ArrayShapeTypeTest extends TestCase
{
    /**
     * @dataProvider provideGeneralize
     */
    public function testGeneralize(ArrayShapeType $type, string $expected) : void
    {
        self::assertEquals($expected, $type->generalize()->__toString());
    }
    /**
     * @return Generator<mixed>
     */
    public function provideGeneralize() : Generator
    {
        (yield [TypeFactory::arrayShape([TypeFactory::stringLiteral('foo'), TypeFactory::stringLiteral('bar')]), 'array{string,string}']);
        (yield [TypeFactory::arrayShape([TypeFactory::stringLiteral('foo'), TypeFactory::arrayShape(['foo' => TypeFactory::intLiteral(12), 'bar' => TypeFactory::intLiteral(12)])]), 'array{string,array{foo:int,bar:int}}']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ArrayShapeTypeTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ArrayShapeTypeTest', \false);
