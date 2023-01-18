<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Type;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClosureType;
use Phpactor202301\Phpactor\WorseReflection\Core\Types;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class ClosureTypeTest extends TestCase
{
    public function testAllTypes() : void
    {
        $reflector = ReflectorBuilder::create()->build();
        $type = new ClosureType($reflector, [TypeFactory::string(), TypeFactory::int()], TypeFactory::string());
        self::assertEquals(new Types([TypeFactory::reflectedClass($reflector, ClassName::fromString('Closure')), TypeFactory::string(), TypeFactory::int(), TypeFactory::string()]), $type->allTypes());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ClosureTypeTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\ClosureTypeTest', \false);
