<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Type;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IntersectionType;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class IntersectionTypeTest extends TestCase
{
    /**
     * @dataProvider provideAccepts
     */
    public function testAccepts(IntersectionType $intersection, Type $type, Trinary $accepts) : void
    {
        self::assertEquals($accepts, $intersection->accepts($type));
    }
    /**
     * @return Generator<mixed>
     */
    public function provideAccepts() : Generator
    {
        (yield 'does not accept non-class types' => [TypeFactory::intersection(TypeFactory::intLiteral(12), TypeFactory::string()), TypeFactory::int(), Trinary::false()]);
        (yield 'does not accept single type' => [TypeFactory::intersection(TypeFactory::class('Foobar'), TypeFactory::class('Barfoo')), TypeFactory::class('Barfoo'), Trinary::false()]);
        (yield 'accepts intersection' => [TypeFactory::intersection(TypeFactory::class('Foobar'), TypeFactory::class('Barfoo')), TypeFactory::intersection(TypeFactory::class('Foobar'), TypeFactory::class('Barfoo')), Trinary::true()]);
        $reflector = ReflectorBuilder::create()->addSource('<?php class A extends B implements C {} class B{} interface C{}')->build();
        (yield 'accepts class that implements intersection interface' => [TypeFactory::intersection(TypeFactory::class('B'), TypeFactory::class('C')), TypeFactory::reflectedClass($reflector, 'A'), Trinary::true()]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\IntersectionTypeTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\IntersectionTypeTest', \false);
