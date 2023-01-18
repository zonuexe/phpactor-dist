<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Unit\Domain;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\NameWithByteOffset;
use Phpactor202301\Phpactor\CodeTransform\Domain\NameWithByteOffsets;
use Phpactor202301\Phpactor\Name\QualifiedName;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
class NameWithByteOffsetsTest extends TestCase
{
    public function testReduceToUniquelyNamedItems() : void
    {
        $names = new NameWithByteOffsets(...[new NameWithByteOffset(QualifiedName::fromString('Foobar'), ByteOffset::fromInt(12)), new NameWithByteOffset(QualifiedName::fromString('Foobar'), ByteOffset::fromInt(22)), new NameWithByteOffset(QualifiedName::fromString('Hallo'), ByteOffset::fromInt(42))]);
        self::assertEquals(new NameWithByteOffsets(...[new NameWithByteOffset(QualifiedName::fromString('Foobar'), ByteOffset::fromInt(12)), new NameWithByteOffset(QualifiedName::fromString('Hallo'), ByteOffset::fromInt(42))]), $names->onlyUniqueNames());
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\NameWithByteOffsetsTest', 'Phpactor\\CodeTransform\\Tests\\Unit\\Domain\\NameWithByteOffsetsTest', \false);
