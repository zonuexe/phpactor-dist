<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Unit\Domain\Name;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\QualifiedName;
class QualifiedNameTest extends TestCase
{
    /**
     * It can say if it is equal to another namespace.
     */
    public function testEqualTo() : void
    {
        $name = QualifiedName::fromString('Phpactor202301\\Foo\\Bar');
        $notMatching = QualifiedName::fromString('Phpactor202301\\Bar\\Bar');
        $matching = QualifiedName::fromString('Phpactor202301\\Foo\\Bar');
        $this->assertFalse($name->isEqualTo($notMatching));
        $this->assertTrue($name->isEqualTo($matching));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\QualifiedNameTest', 'Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\QualifiedNameTest', \false);
