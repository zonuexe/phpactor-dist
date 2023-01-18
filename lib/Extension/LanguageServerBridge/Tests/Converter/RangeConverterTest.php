<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\Tests\Converter;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\RangeConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
class RangeConverterTest extends TestCase
{
    public function testConvertsRanges() : void
    {
        $text = '1234567890';
        $start = ByteOffset::fromInt(1);
        $end = ByteOffset::fromInt(4);
        self::assertEquals(new Range(PositionConverter::byteOffsetToPosition($start, $text), PositionConverter::byteOffsetToPosition($end, $text)), RangeConverter::toLspRange(ByteOffsetRange::fromByteOffsets($start, $end), $text));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\Tests\\Converter\\RangeConverterTest', 'Phpactor\\Extension\\LanguageServerBridge\\Tests\\Converter\\RangeConverterTest', \false);
