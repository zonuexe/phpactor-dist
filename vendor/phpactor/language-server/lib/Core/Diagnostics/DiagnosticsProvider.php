<?php

namespace Phpactor\LanguageServer\Core\Diagnostics;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
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
