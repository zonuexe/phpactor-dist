<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter;

use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit as LspTextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
class TextEditConverter
{
    /**
     * @param TextEdits<TextEdit> $textEdits
     * @return array<LspTextEdit>
     */
    public static function toLspTextEdits(TextEdits $textEdits, string $text) : array
    {
        $edits = [];
        foreach ($textEdits as $textEdit) {
            $range = new Range(PositionConverter::byteOffsetToPosition($textEdit->start(), $text), PositionConverter::byteOffsetToPosition($textEdit->end(), $text));
            // deduplicate text edits
            $edits[] = new LspTextEdit($range, $textEdit->replacement());
        }
        return \array_values($edits);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\Converter\\TextEditConverter', 'Phpactor\\Extension\\LanguageServerBridge\\Converter\\TextEditConverter', \false);
