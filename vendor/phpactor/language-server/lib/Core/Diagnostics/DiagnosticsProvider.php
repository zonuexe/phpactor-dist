<?php

namespace Phpactor\LanguageServer\Core\Diagnostics;

use PhpactorDist\Amp\CancellationToken;
use PhpactorDist\Amp\Promise;
use Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
interface DiagnosticsProvider
{
    /**
     * @return Promise<array<Diagnostic>>
     */
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise;
    public function name() : string;
}
