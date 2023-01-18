<?php

namespace Phpactor202301\Phpactor\Name\Tests\Unit;

use Phpactor202301\Phpactor\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\Name\QualifiedName;
class QualifiedNameTest extends AbstractQualifiedNameTestCase
{
    public function testCanBeConvertedToFullyQualifiedName() : void
    {
        $this->assertEquals(FullyQualifiedName::fromString('Phpactor202301\\Foobar\\Barfoo'), $this->createFromString('Phpactor202301\\Foobar\\Barfoo')->toFullyQualifiedName());
    }
    protected function createFromArray(array $parts)
    {
        return QualifiedName::fromArray($parts);
    }
    protected function createFromString(string $string) : QualifiedName
    {
        return QualifiedName::fromString($string);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Name\\Tests\\Unit\\QualifiedNameTest', 'Phpactor\\Name\\Tests\\Unit\\QualifiedNameTest', \false);
