<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
class NameTest extends TestCase
{
    public function testHead() : void
    {
        $name = Name::fromString('Phpactor202301\\Foo\\Bar\\Baz');
        $this->assertEquals('Foo', (string) $name->head());
    }
    public function testTail() : void
    {
        $name = Name::fromString('Phpactor202301\\Foo\\Bar\\Baz');
        $this->assertEquals('Phpactor202301\\Bar\\Baz', (string) $name->tail());
    }
    public function testIsFullyQualified() : void
    {
        $name = Name::fromString('Phpactor202301\\Foo\\Bar\\Baz');
        $this->assertTrue($name->wasFullyQualified());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\NameTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\NameTest', \false);
