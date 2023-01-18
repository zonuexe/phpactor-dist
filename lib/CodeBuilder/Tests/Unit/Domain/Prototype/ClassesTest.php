<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Prototype;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\ClassPrototype;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Classes;
class ClassesTest extends TestCase
{
    /**
     * @testdox Create from classes
     */
    public function testCreateFromClasses() : void
    {
        $classes = Classes::fromClasses([new ClassPrototype('One'), new ClassPrototype('Two')]);
        $this->assertCount(2, \iterator_to_array($classes));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\ClassesTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Prototype\\ClassesTest', \false);
