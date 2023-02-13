<?php

namespace Phpactor\Extension\LanguageServerPsalm\DiagnosticProvider;

use PhpactorDist\Amp\CancellationToken;
use PhpactorDist\Amp\Promise;
use Phpactor\Extension\LanguageServerPsalm\Model\Linter;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
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
