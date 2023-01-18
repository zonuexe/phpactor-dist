<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Type;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\CallableType;
use Phpactor202301\Phpactor\WorseReflection\Core\Types;
class CallableTypeTest extends TestCase
{
    public function testToStringWithNoType() : void
    {
        self::assertEquals('callable()', TypeFactory::callable()->__toString());
    }
    public function testToStringWithReturnType() : void
    {
        self::assertEquals('callable(): string', (new CallableType([], TypeFactory::string()))->__toString());
    }
    public function testAllTypes() : void
    {
        $type = new CallableType([TypeFactory::string(), TypeFactory::int()], TypeFactory::string());
        self::assertEquals(new Types([TypeFactory::string(), TypeFactory::int(), TypeFactory::string()]), $type->allTypes());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\CallableTypeTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Type\\CallableTypeTest', \false);
