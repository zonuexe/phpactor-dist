<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\CreateClassCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Diagnostic;
use Phpactor202301\Phpactor\LanguageServerProtocol\DiagnosticSeverity;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use function Phpactor202301\Amp\call;
class CreateClassProvider implements DiagnosticsProvider, CodeActionProvider
{
    public const KIND = 'quickfix.create_class';
    public function __construct(private Generators $generators, private Parser $parser)
    {
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
    public function provideDiagnostics(TextDocumentItem $textDocument, CancellationToken $cancel) : Promise
    {
        return new Success($this->getDiagnostics($textDocument));
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument) {
            $diagnostics = $this->getDiagnostics($textDocument);
            if (empty($diagnostics)) {
                return [];
            }
            $actions = [];
            foreach ($this->generators as $name => $generator) {
                $title = \sprintf('Create new "%s" class', $name);
                $actions[] = CodeAction::fromArray(['title' => $title, 'kind' => self::KIND, 'diagnostics' => $diagnostics, 'command' => new Command($title, CreateClassCommand::NAME, [$textDocument->uri, $name])]);
            }
            return $actions;
        });
    }
    public function name() : string
    {
        return 'create-class';
    }
    /**
     * @return array<Diagnostic>
     */
    private function getDiagnostics(TextDocumentItem $textDocument) : array
    {
        if ('' !== \trim($textDocument->text)) {
            return [];
        }
        return [new Diagnostic(new Range(new Position(1, 1), new Position(1, 1)), \sprintf('Empty file (use create-class code action to create a new class)'), DiagnosticSeverity::INFORMATION, null, 'phpactor')];
    }
    private function kind() : string
    {
        return self::KIND;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\CreateClassProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\CreateClassProvider', \false);
