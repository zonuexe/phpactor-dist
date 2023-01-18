<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractExpression;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ExtractExpressionCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use function Phpactor202301\Amp\call;
class ExtractExpressionProvider implements CodeActionProvider
{
    public const KIND = 'refactor.extract.expression';
    public function __construct(private ExtractExpression $extractExpression)
    {
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument, $range) {
            if (!$this->extractExpression->canExtractExpression(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri), PositionConverter::positionToByteOffset($range->start, $textDocument->text)->toInt(), PositionConverter::positionToByteOffset($range->end, $textDocument->text)->toInt())) {
                return [];
            }
            return [CodeAction::fromArray(['title' => 'Extract expression', 'kind' => self::KIND, 'diagnostics' => [], 'command' => new Command('Extract method', ExtractExpressionCommand::NAME, [$textDocument->uri, PositionConverter::positionToByteOffset($range->start, $textDocument->text)->toInt(), PositionConverter::positionToByteOffset($range->end, $textDocument->text)->toInt()])])];
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\ExtractExpressionProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\ExtractExpressionProvider', \false);
