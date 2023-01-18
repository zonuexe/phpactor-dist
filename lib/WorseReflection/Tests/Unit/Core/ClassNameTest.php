<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use stdClass;
class ClassNameTest extends TestCase
{
    const CLASS_NAME = 'Foobar';
    public function testFromUnknownReturnsClassNameIfGivenClassName() : void
    {
        $givenClass = ClassName::fromString(self::CLASS_NAME);
        $className = ClassName::fromUnknown($givenClass);
        $this->assertSame($givenClass, $className);
    }
    public function testFromUnknownString() : void
    {
        $className = ClassName::fromUnknown(self::CLASS_NAME);
        $this->assertEquals(ClassName::fromString(self::CLASS_NAME), $className);
    }
    public function testFromUnknownInvalid() : void
    {
        $this->expectExceptionMessage('Do not know how to create class');
        ClassName::fromUnknown(new stdClass());
    }
    public function testFromUnknownClassName() : void
    {
        $className1 = ClassName::fromString('Foobar');
        $className2 = ClassName::fromUnknown($className1);
        $this->assertSame($className1, $className2);
    }
    public function testPrepend() : void
    {
        $className1 = ClassName::fromString('Foobar');
        $className2 = ClassName::fromString('Barfoo');
        $className3 = $className1->prepend($className2);
        $this->assertEquals('Phpactor202301\\Barfoo\\Foobar', (string) $className3);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\ClassNameTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\ClassNameTest', \false);
