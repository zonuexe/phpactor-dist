<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\WorseReflection\Core\Offset;
use stdClass;
class OffsetTest extends TestCase
{
    const OFFSET = 123;
    public function testFromPhpactorByteOffset() : void
    {
        $byteOffset = ByteOffset::fromInt(self::OFFSET);
        $offset = Offset::fromUnknown($byteOffset);
        $this->assertSame(self::OFFSET, $offset->toInt());
    }
    public function testFromUnknownReturnsOffsetIfGivenOffset() : void
    {
        $givenOffset = Offset::fromInt(self::OFFSET);
        $offset = Offset::fromUnknown($givenOffset);
        $this->assertSame($givenOffset, $offset);
    }
    public function testFromUnknownString() : void
    {
        $offset = Offset::fromUnknown(self::OFFSET);
        $this->assertEquals(Offset::fromInt(self::OFFSET), $offset);
    }
    public function testFromUnknownInvalid() : void
    {
        $this->expectExceptionMessage('Do not know how to create offset');
        Offset::fromUnknown(new stdClass());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\OffsetTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\OffsetTest', \false);
