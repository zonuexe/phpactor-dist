<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Type;

use Generator;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayLiteral;
class ArrayLiteralTypeTest extends TestCase
{
    /**
     * @dataProvider provideGeneralize
     */
    public function testGeneralize(ArrayLiteral $type, string $expected) : void
    {
        self::assertEquals($expected, $type->generalize()->__toString());
    }
    /**
     * @return Generator<mixed>
     */
    public function provideGeneralize() : Generator
    {
        (yield [
            // ['foo','bar']
            TypeFactory::arrayLiteral([TypeFactory::stringLiteral('foo'), TypeFactory::stringLiteral('bar')]),
            'array<int,string>',
        ]);
        (yield [TypeFactory::arrayLiteral([TypeFactory::arrayLiteral([TypeFactory::stringLiteral('one'), TypeFactory::stringLiteral('two')]), TypeFactory::arrayLiteral([TypeFactory::stringLiteral('one'), TypeFactory::stringLiteral('two')])]), 'array<int,array<int,string>>']);
        (yield [
            // ['foo','bar']
            TypeFactory::arrayLiteral([TypeFactory::arrayShape(['foo' => TypeFactory::intLiteral(12), 'bar' => TypeFactory::intLiteral(12)])]),
            'array<int,array{foo:int,bar:int}>',
        ]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ArrayLiteralTypeTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ArrayLiteralTypeTest', \false);
