<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPsalm\DiagnosticProvider;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Model\Linter;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
class PsalmDiagnosticProvider implements DiagnosticsProvider
{
    public function __construct(private Linter $linter)
    {
    }
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        return $this->linter->lint($textDocument->uri, $textDocument->text);
    }
    public function name() : string
    {
        return 'psalm';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPsalm\\DiagnosticProvider\\PsalmDiagnosticProvider', 'Phpactor\\Extension\\LanguageServerPsalm\\DiagnosticProvider\\PsalmDiagnosticProvider', \false);
