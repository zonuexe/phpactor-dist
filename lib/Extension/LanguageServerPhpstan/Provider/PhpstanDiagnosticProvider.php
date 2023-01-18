<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Provider;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Model\Linter;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
class PhpstanDiagnosticProvider implements DiagnosticsProvider
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
        return 'phpstan';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Provider\\PhpstanDiagnosticProvider', 'Phpactor\\Extension\\LanguageServerPhpstan\\Provider\\PhpstanDiagnosticProvider', \false);
