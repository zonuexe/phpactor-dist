<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerDiagnostics\Provider;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerDiagnostics\Model\PhpLinter;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use function Phpactor202301\Amp\call;
class PhpLintDiagnosticProvider implements DiagnosticsProvider
{
    public function __construct(private PhpLinter $linter, private TextDocumentLocator $locator)
    {
    }
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument) {
            return $this->linter->lint($this->locator->get(TextDocumentUri::fromString($textDocument->uri)));
        });
    }
    public function name() : string
    {
        return 'php-lint';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerDiagnostics\\Provider\\PhpLintDiagnosticProvider', 'Phpactor\\Extension\\LanguageServerDiagnostics\\Provider\\PhpLintDiagnosticProvider', \false);
