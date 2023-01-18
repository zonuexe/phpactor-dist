<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractMethod;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ExtractMethodCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use function Phpactor202301\Amp\call;
class ExtractMethodProvider implements CodeActionProvider
{
    public const KIND = 'refactor.extract.method';
    public function __construct(private ExtractMethod $extractMethod)
    {
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument, $range) {
            if (!$this->extractMethod->canExtractMethod(SourceCode::fromStringAndPath($textDocument->text, $textDocument->uri), PositionConverter::positionToByteOffset($range->start, $textDocument->text)->toInt(), PositionConverter::positionToByteOffset($range->end, $textDocument->text)->toInt())) {
                return [];
            }
            return [CodeAction::fromArray(['title' => 'Extract method', 'kind' => self::KIND, 'diagnostics' => [], 'command' => new Command('Extract method', ExtractMethodCommand::NAME, [$textDocument->uri, PositionConverter::positionToByteOffset($range->start, $textDocument->text)->toInt(), PositionConverter::positionToByteOffset($range->end, $textDocument->text)->toInt()])])];
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\ExtractMethodProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\ExtractMethodProvider', \false);
