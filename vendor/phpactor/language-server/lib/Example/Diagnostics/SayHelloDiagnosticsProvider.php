<?php

namespace Phpactor202301\Phpactor\LanguageServer\Example\Diagnostics;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use function Phpactor202301\Amp\call;
class SayHelloDiagnosticsProvider implements DiagnosticsProvider
{
    /**
     * {@inheritDoc}
     */
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        return call(function () {
            return [new Diagnostic(new Range(new Position(0, 0), new Position(1, 0)), 'This is the first line, hello!', DiagnosticSeverity::INFORMATION)];
        });
    }
    public function name() : string
    {
        return 'say-hello';
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Example\\Diagnostics\\SayHelloDiagnosticsProvider', 'Phpactor\\LanguageServer\\Example\\Diagnostics\\SayHelloDiagnosticsProvider', \false);
