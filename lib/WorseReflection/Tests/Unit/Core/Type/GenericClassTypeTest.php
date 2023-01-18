<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Type;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\GenericClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Types;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class GenericClassTypeTest extends TestCase
{
    public function testAllTypes() : void
    {
        $reflector = ReflectorBuilder::create()->build();
        $type = new GenericClassType($reflector, ClassName::fromString('Foo'), [TypeFactory::string(), TypeFactory::int()]);
        self::assertEquals(new Types([TypeFactory::reflectedClass($reflector, ClassName::fromString('Foo')), TypeFactory::string(), TypeFactory::int()]), $type->allTypes());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\GenericClassTypeTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\GenericClassTypeTest', \false);
