<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Type;

use Generator;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IntType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\StringType;
class ArrayTypeTest extends TestCase
{
    /**
     * @dataProvider provideToString
     */
    public function testToString(ArrayType $type, string $expected) : void
    {
        self::assertEquals($expected, $type->__toString());
    }
    /**
     * @return Generator<mixed>
     */
    public function provideToString() : Generator
    {
        (yield [new ArrayType(new StringType()), 'string[]']);
        (yield [new ArrayType(null, new StringType()), 'string[]']);
        (yield [new ArrayType(new IntType(), new StringType()), 'array<int,string>']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ArrayTypeTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ArrayTypeTest', \false);
