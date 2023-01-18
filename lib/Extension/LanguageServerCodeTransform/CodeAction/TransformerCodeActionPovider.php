<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformers;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextDocumentConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Converter\DiagnosticsConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\TransformCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use function Phpactor202301\Amp\call;
class TransformerCodeActionPovider implements DiagnosticsProvider, CodeActionProvider
{
    public function __construct(private Transformers $transformers, private string $name, private string $title)
    {
    }
    public function kinds() : array
    {
        return [$this->kind()];
    }
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        return new Success($this->getDiagnostics($textDocument, $cancel));
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument) {
            $diagnostics = $this->getDiagnostics($textDocument);
            if (0 === \count($diagnostics)) {
                return [];
            }
            return [CodeAction::fromArray(['title' => $this->title, 'kind' => $this->kind(), 'diagnostics' => $diagnostics, 'command' => new Command($this->title, TransformCommand::NAME, [$textDocument->uri, $this->name])])];
        });
    }
    public function name() : string
    {
        return $this->name;
    }
    /**
     * @return array<Diagnostic>
     */
    private function getDiagnostics(TextDocumentItem $textDocument) : array
    {
        $phpactorTextDocument = TextDocumentConverter::fromLspTextItem($textDocument);
        return \array_map(function (Diagnostic $diagnostic) {
            $diagnostic->message = \sprintf('%s (fix with "%s" code action)', $diagnostic->message, $this->title);
            return $diagnostic;
        }, DiagnosticsConverter::toLspDiagnostics($phpactorTextDocument, $this->transformers->get($this->name)->diagnostics(SourceCode::fromTextDocument(TextDocumentConverter::fromLspTextItem($textDocument)))));
    }
    private function kind() : string
    {
        return 'quickfix.' . $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\TransformerCodeActionPovider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\TransformerCodeActionPovider', \false);
