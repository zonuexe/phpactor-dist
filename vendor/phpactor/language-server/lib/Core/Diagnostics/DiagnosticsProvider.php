<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
interface DiagnosticsProvider
{
    /**
     * @return Promise<array<Diagnostic>>
     */
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise;
    public function name() : string;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Diagnostics\\DiagnosticsProvider', 'Phpactor\\LanguageServer\\Core\\Diagnostics\\DiagnosticsProvider', \false);
