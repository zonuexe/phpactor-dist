<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Unit\Domain\Name;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\NamespacedClassReferences;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\ClassReference;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\QualifiedName;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\Position;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\Namespace_;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\NamespaceReference;
use Phpactor202301\Phpactor\ClassMover\Domain\Reference\ImportedNameReference;
class NamespacedClassRefListTest extends TestCase
{
    /**
     * It should filter for name.
     */
    public function testFilterForName() : void
    {
        $refList = NamespacedClassReferences::fromNamespaceAndClassRefs(NamespaceReference::fromNameAndPosition(Namespace_::fromString('Foo'), Position::fromStartAndEnd(1, 2)), [ClassReference::fromNameAndPosition(QualifiedName::fromString('Foo'), FullyQualifiedName::fromString('Phpactor202301\\Foo\\Bar'), Position::fromStartAndEnd(10, 12), ImportedNameReference::none()), ClassReference::fromNameAndPosition(QualifiedName::fromString('Foo'), FullyQualifiedName::fromString('Phpactor202301\\Foo\\Bar'), Position::fromStartAndEnd(10, 12), ImportedNameReference::none()), ClassReference::fromNameAndPosition(QualifiedName::fromString('Bar'), FullyQualifiedName::fromString('Phpactor202301\\Bar\\Bar'), Position::fromStartAndEnd(10, 12), ImportedNameReference::none())]);
        $this->assertCount(2, $refList->filterForName(FullyQualifiedName::fromString('Phpactor202301\\Foo\\Bar')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\NamespacedClassRefListTest', 'Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\NamespacedClassRefListTest', \false);
