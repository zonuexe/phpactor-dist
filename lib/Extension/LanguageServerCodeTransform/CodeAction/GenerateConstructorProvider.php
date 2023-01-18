<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateConstructor;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\RangeConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextDocumentConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\WorkspaceEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
class GenerateConstructorProvider implements CodeActionProvider
{
    const KIND = 'quickfix.generate.constructor';
    public function __construct(private GenerateConstructor $generateConstructor, private WorkspaceEditConverter $converter)
    {
    }
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        $edits = $this->generateConstructor->generateMethod(TextDocumentConverter::fromLspTextItem($textDocument), RangeConverter::toPhpactorRange($range, $textDocument->text)->start());
        if (\count($edits) === 0) {
            return new Success([]);
        }
        return new Success([new CodeAction('Generate constructor', self::KIND, [], \false, $this->converter->toLspWorkspaceEdit($edits))]);
    }
    public function kinds() : array
    {
        return [self::KIND];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\GenerateConstructorProvider', 'Phpactor\\Extension\\LanguageServerCodeTransform\\CodeAction\\GenerateConstructorProvider', \false);
