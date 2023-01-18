<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\NameImports;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use RuntimeException;
class NameImportsTest extends TestCase
{
    public function testByAlias() : void
    {
        $imports = NameImports::fromNames(['Barfoo' => Name::fromString('Phpactor202301\\Foobar\\Barfoo')]);
        $this->assertTrue($imports->hasAlias('Barfoo'));
        $this->assertEquals(Name::fromString('Phpactor202301\\Foobar\\Barfoo'), $imports->getByAlias('Barfoo'));
    }
    public function testResolveAliasedLocalName() : void
    {
        $imports = NameImports::fromNames(['Baz' => Name::fromString('Phpactor202301\\Foobar\\Barfoo')]);
        $this->assertEquals(Name::fromString('Baz'), $imports->resolveLocalName(Name::fromString('Phpactor202301\\Foobar\\Barfoo')));
    }
    public function testResolveRelativeAliasedLocalName() : void
    {
        $imports = NameImports::fromNames(['Baz' => Name::fromString('Phpactor202301\\Foobar\\Barfoo')]);
        $this->assertEquals(Name::fromString('Phpactor202301\\Baz\\Zoz'), $imports->resolveLocalName(Name::fromString('Phpactor202301\\Foobar\\Barfoo\\Zoz')));
    }
    public function testResolveRelativeAliasedLocalName2() : void
    {
        $imports = NameImports::fromNames(['Baz' => Name::fromString('Phpactor202301\\Foobar\\Barfoo')]);
        $this->assertEquals(Name::fromString('Phpactor202301\\Baz\\Zoz\\Foo'), $imports->resolveLocalName(Name::fromString('Phpactor202301\\Foobar\\Barfoo\\Zoz\\Foo')));
    }
    public function testLocalNameIfNoImport() : void
    {
        $imports = NameImports::fromNames([]);
        $this->assertEquals(Name::fromString('Foo'), $imports->resolveLocalName(Name::fromString('Phpactor202301\\Foobar\\Barfoo\\Zoz\\Foo')));
    }
    public function testAliasNotFound() : void
    {
        $this->expectException(RuntimeException::class);
        $imports = NameImports::fromNames([]);
        $imports->getByAlias('Barfoo');
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\NameImportsTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\NameImportsTest', \false);
