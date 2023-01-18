<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Converter;

use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostic;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostics;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic as LspDiagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
final class DiagnosticsConverter
{
    public static function toLspDiagnostics(TextDocument $textDocument, Diagnostics $diagnostics) : array
    {
        $lspDiagnostics = [];
        foreach ($diagnostics as $diagnostic) {
            $lspDiagnostics[] = self::toLspDiagnostic($textDocument, $diagnostic);
        }
        return $lspDiagnostics;
    }
    public static function toLspDiagnostic(TextDocument $textDocument, Diagnostic $diagnostic) : LspDiagnostic
    {
        return LspDiagnostic::fromArray(['range' => new Range(PositionConverter::byteOffsetToPosition($diagnostic->range()->start(), $textDocument->__toString()), PositionConverter::byteOffsetToPosition($diagnostic->range()->end(), $textDocument->__toString())), 'message' => $diagnostic->message(), 'source' => 'phpactor', 'severity' => $diagnostic->severity()]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Converter\\DiagnosticsConverter', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Converter\\DiagnosticsConverter', \false);
