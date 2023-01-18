<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\FillObject;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\RangeConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextDocumentConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
class FillObjectProvider implements CodeActionProvider
{
    const KIND = 'quickfix.fill.object';
    public function __construct(private FillObject $fillObject)
    {
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        $edits = $this->fillObject->fillObject(TextDocumentConverter::fromLspTextItem($textDocument), RangeConverter::toPhpactorRange($range, $textDocument->text)->start());
        if (\count($edits) === 0) {
            return new Success([]);
        }
        return new Success([new CodeAction('Fill object', self::KIND, [], \false, new WorkspaceEdit([$textDocument->uri => TextEditConverter::toLspTextEdits($edits, $textDocument->text)]))]);
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\FillObjectProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\FillObjectProvider', \false);
