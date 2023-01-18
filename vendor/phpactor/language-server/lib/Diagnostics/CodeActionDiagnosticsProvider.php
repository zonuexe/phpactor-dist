<?php

namespace Phpactor202301\Phpactor\LanguageServer\Diagnostics;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use function Phpactor202301\Amp\call;
class CodeActionDiagnosticsProvider implements DiagnosticsProvider
{
    /**
     * @var array<CodeActionProvider>
     */
    private $providers;
    public function __construct(CodeActionProvider ...$providers)
    {
        $this->providers = $providers;
    }
    /**
     * {@inheritDoc}
     */
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument, $cancel) {
            $diagnostics = [];
            foreach ($this->providers as $provider) {
                $codeActions = (yield $provider->provideActionsFor($textDocument, new Range(new Position(0, 0), new Position(\PHP_INT_MAX, \PHP_INT_MAX)), $cancel));
                foreach ($codeActions as $codeAction) {
                    foreach ($codeAction->diagnostics as $diagnostic) {
                        $diagnostics[] = $diagnostic;
                    }
                }
                $cancel->throwIfRequested();
            }
            return $diagnostics;
        });
    }
    public function name() : string
    {
        return 'code-action';
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Diagnostics\\CodeActionDiagnosticsProvider', 'Phpactor\\LanguageServer\\Diagnostics\\CodeActionDiagnosticsProvider', \false);
