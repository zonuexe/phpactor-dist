<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Prototype;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\SourceCode;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\NamespaceName;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\UseStatements;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Classes;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Interfaces;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Traits;
class SourceCodeTest extends TestCase
{
    public function testAccessors() : void
    {
        $namespace = NamespaceName::fromString('Ducks');
        $useStatements = UseStatements::empty();
        $classes = Classes::empty();
        $interfaces = Interfaces::empty();
        $traits = Traits::empty();
        $code = new SourceCode($namespace, $useStatements, $classes, $interfaces, $traits);
        $this->assertSame($namespace, $code->namespace());
        $this->assertSame($useStatements, $code->useStatements());
        $this->assertSame($classes, $code->classes());
        $this->assertSame($interfaces, $code->interfaces());
        $this->assertSame($traits, $code->traits());
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\SourceCodeTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\SourceCodeTest', \false);
