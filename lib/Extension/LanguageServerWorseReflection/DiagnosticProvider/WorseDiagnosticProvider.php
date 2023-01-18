<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\DiagnosticProvider;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity as LanguageServerProtocolDiagnosticSeverity;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticSeverity;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use function Phpactor202301\Amp\call;
class WorseDiagnosticProvider implements DiagnosticsProvider
{
    public function __construct(private Reflector $reflector)
    {
    }
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument, $cancel) {
            $lspDiagnostics = [];
            foreach ($this->reflector->diagnostics($textDocument->text) as $diagnostic) {
                $range = new Range(PositionConverter::byteOffsetToPosition($diagnostic->range()->start(), $textDocument->text), PositionConverter::byteOffsetToPosition($diagnostic->range()->end(), $textDocument->text));
                $lspDiagnostic = ProtocolFactory::diagnostic($range, $diagnostic->message());
                $lspDiagnostic->severity = self::toLspSeverity($diagnostic->severity());
                $lspDiagnostics[] = $lspDiagnostic;
                if ($cancel->isRequested()) {
                    return $lspDiagnostics;
                }
            }
            return $lspDiagnostics;
        });
    }
    public function name() : string
    {
        return 'worse';
    }
    /**
     * @return LanguageServerProtocolDiagnosticSeverity::*
     */
    private static function toLspSeverity(DiagnosticSeverity $diagnosticSeverity) : int
    {
        if ($diagnosticSeverity->isError()) {
            return LanguageServerProtocolDiagnosticSeverity::ERROR;
        }
        if ($diagnosticSeverity->isWarning()) {
            return LanguageServerProtocolDiagnosticSeverity::WARNING;
        }
        return LanguageServerProtocolDiagnosticSeverity::INFORMATION;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\DiagnosticProvider\\WorseDiagnosticProvider', 'Phpactor\\Extension\\LanguageServerWorseReflection\\DiagnosticProvider\\WorseDiagnosticProvider', \false);
