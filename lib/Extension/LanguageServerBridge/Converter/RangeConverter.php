<?php

namespace Phpactor\Extension\LanguageServerBridge\Converter;

use Phpactor\LanguageServerProtocol\Range;
use Phpactor\TextDocument\ByteOffsetRange;
class RangeConverter
{
    public static function toLspRange(ByteOffsetRange $range, string $text) : Range
    {
        return new Range(\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter::byteOffsetToPosition($range->start(), $text), \Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter::byteOffsetToPosition($range->end(), $text));
    }
    public static function toPhpactorRange(Range $range, string $text) : ByteOffsetRange
    {
        return new ByteOffsetRange(\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter::positionToByteOffset($range->start, $text), \Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter::positionToByteOffset($range->end, $text));
    }
}
