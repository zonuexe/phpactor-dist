<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
interface CodeActionProvider
{
    /**
     * @return Promise<array<CodeAction>>
     */
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise;
    /**
     * Return the kinds of actions that this provider can return, for example
     * "refactor.extract", "quickfix", etc.
     *
     * @see Phpactor\LanguageServerProtocol\CodeAction
     *
     * @return array<string>
     */
    public function kinds() : array;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\CodeAction\\CodeActionProvider', 'Phpactor\\LanguageServer\\Core\\CodeAction\\CodeActionProvider', \false);
