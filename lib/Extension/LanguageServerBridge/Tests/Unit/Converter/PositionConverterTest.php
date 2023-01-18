<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\Tests\Unit\Converter;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
class PositionConverterTest extends TestCase
{
    public function testWhenOutOfBoundsAssumeEndOfDocument() : void
    {
        self::assertEquals(new Position(0, 10), PositionConverter::byteOffsetToPosition(ByteOffset::fromInt(20), '0123456789'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\Tests\\Unit\\Converter\\PositionConverterTest', 'Phpactor\\Extension\\LanguageServerBridge\\Tests\\Unit\\Converter\\PositionConverterTest', \false);
