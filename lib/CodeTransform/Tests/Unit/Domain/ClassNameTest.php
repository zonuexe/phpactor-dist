<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Unit\Domain;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
class ClassNameTest extends TestCase
{
    /**
     * It returns the namespace
     */
    public function testNamespace() : void
    {
        $class = ClassName::fromString('Phpactor202301\\This\\Is\\A\\Namespace\\ClassName');
        $this->assertEquals('Phpactor202301\\This\\Is\\A\\Namespace', $class->namespace());
    }
    /**
     * It returns empty strsing if no namespace
     */
    public function testNamespaceNone() : void
    {
        $class = ClassName::fromString('ClassName');
        $this->assertEquals('', $class->namespace());
    }
    /**
     * @testdox It returns the class short name
     */
    public function testShort() : void
    {
        $class = ClassName::fromString('Phpactor202301\\Namespace\\ClassName');
        $this->assertEquals('ClassName', $class->short());
    }
    /**
     * @testdox It returns the class short name with no namespace
     */
    public function testShortNoNamespace() : void
    {
        $class = ClassName::fromString('ClassName');
        $this->assertEquals('ClassName', $class->short());
    }
    /**
     * @testdox It throws exception if classname is empty.
     */
    public function testEmpty() : void
    {
        $this->expectExceptionMessage('Class name cannot be empty');
        ClassName::fromString('');
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\ClassNameTest', 'Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\ClassNameTest', \false);
