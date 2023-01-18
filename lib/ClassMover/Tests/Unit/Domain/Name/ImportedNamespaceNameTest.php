<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Unit\Domain\Name;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\ImportedName;
use InvalidArgumentException;
class ImportedNamespaceNameTest extends TestCase
{
    /**
     * @testdox It show replace the head.
     */
    public function testWithAlias() : void
    {
        $imported = ImportedName::fromString('Phpactor202301\\Foobar\\Barfoo\\FooFoo');
        $imported = $imported->withAlias('BarBar');
        $this->assertEquals('Phpactor202301\\Foobar\\Barfoo\\FooFoo', $imported->__toString());
    }
    /**
     * @testdox It allows single part namespace.
     */
    public function testSinglePart() : void
    {
        $imported = ImportedName::fromString('Foobar');
        $this->assertEquals('Foobar', $imported->__toString());
    }
    /**
     * @testdox It does not allow empty namespace.
     */
    public function testEmpty() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name cannot be empty');
        ImportedName::fromString('');
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\ImportedNamespaceNameTest', 'Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\ImportedNamespaceNameTest', \false);
