<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\GenericClassType;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class TypeUtilTest extends TestCase
{
    /**
     * @dataProvider provideToLocalType
     */
    public function testToLocalType(string $source, Type $type, string $expected) : void
    {
        $reflector = ReflectorBuilder::create()->addSource($source)->build();
        $class = $reflector->reflectClassLike('Foo');
        self::assertEquals($expected, (string) $type->toLocalType($class->scope()));
    }
    public function provideToLocalType() : Generator
    {
        $reflector = ReflectorBuilder::create()->build();
        (yield ['<?php class Foo{}', TypeFactory::string(), 'string']);
        (yield ['<?php class Foo{}', TypeFactory::class('Phpactor202301\\Foo\\Baz'), 'Baz']);
        (yield ['<?php use Foo\\Baz as Boo; class Foo{}', TypeFactory::class('Phpactor202301\\Foo\\Baz'), 'Boo']);
        (yield ['<?php use Foo\\Baz as Boo; class Foo{}', TypeFactory::array(TypeFactory::class('Phpactor202301\\Foo\\Baz')), 'Boo[]']);
        (yield ['<?php use Foo\\Baz as Boo; class Foo{}', new GenericClassType($reflector, ClassName::fromString('Foo'), [TypeFactory::fromString('string'), TypeFactory::fromString('Phpactor202301\\Foo\\Baz')]), 'Foo<string,Boo>']);
    }
    /**
     * @dataProvider provideShort
     */
    public function testShort(Type $type, string $expected) : void
    {
        self::assertEquals($expected, $type->short());
    }
    public function provideShort() : Generator
    {
        (yield 'scalar' => [TypeFactory::string(), 'string']);
        (yield 'Root class' => [TypeFactory::class('Foo'), 'Foo']);
        (yield 'Namespaced class' => [TypeFactory::class('Phpactor202301\\Foo\\Bar'), 'Bar']);
        (yield 'Union' => [TypeFactory::union(TypeFactory::class('Phpactor202301\\Foo\\Bar')), 'Bar']);
        (yield 'Union with two elements' => [TypeFactory::union(TypeFactory::class('Phpactor202301\\Foo\\Bar'), TypeFactory::class('Phpactor202301\\Foo\\Baz')), 'Bar|Baz']);
    }
    /**
     * @dataProvider provideShortenClassTypes
     */
    public function testShortenClassTypes(Type $type, string $expected) : void
    {
        self::assertEquals($expected, TypeUtil::shortenClassTypes($type)->__toString());
    }
    public function provideShortenClassTypes() : Generator
    {
        (yield 'scalar' => [TypeFactory::string(), 'string']);
        (yield 'Root class' => [TypeFactory::class('Foo'), 'Foo']);
        (yield 'Namespaced class' => [TypeFactory::class('Phpactor202301\\Foo\\Bar'), 'Bar']);
        (yield 'Union' => [TypeFactory::union(TypeFactory::class('Phpactor202301\\Foo\\Bar')), 'Bar']);
        (yield 'Union with two elements' => [TypeFactory::union(TypeFactory::class('Phpactor202301\\Foo\\Bar'), TypeFactory::class('Phpactor202301\\Foo\\Baz')), 'Bar|Baz']);
        (yield 'Static' => [TypeFactory::static(TypeFactory::class('Phpactor202301\\Foo\\Bar')), 'static(Bar)']);
        (yield 'This' => [TypeFactory::this(TypeFactory::class('Phpactor202301\\Foo\\Bar')), '$this(Bar)']);
        (yield 'Nullable' => [TypeFactory::nullable(TypeFactory::class('Phpactor202301\\Foo\\Bar')), '?Bar']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\TypeUtilTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\TypeUtilTest', \false);
