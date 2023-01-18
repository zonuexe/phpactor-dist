<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ReplaceQualifierWithImport;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ReplaceQualifierWithImportCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use function Phpactor202301\Amp\call;
class ReplaceQualifierWithImportProvider implements CodeActionProvider
{
    public const KIND = 'refactor.class.simplify';
    public function __construct(private ReplaceQualifierWithImport $replaceQualifierWithImport)
    {
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument, $range) {
            if (!$this->replaceQualifierWithImport->canReplaceWithImport(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri), PositionConverter::positionToByteOffset($range->start, $textDocument->text)->toInt())) {
                return [];
            }
            return [CodeAction::fromArray(['title' => 'Replace qualifier with import', 'kind' => self::KIND, 'diagnostics' => [], 'command' => new Command('Replace qualifier with import', ReplaceQualifierWithImportCommand::NAME, [$textDocument->uri, PositionConverter::positionToByteOffset($range->start, $textDocument->text)->toInt()])])];
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\ReplaceQualifierWithImportProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\ReplaceQualifierWithImportProvider', \false);
