<?php

namespace Phpactor\LanguageServer\Core\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor\LanguageServerProtocol\Range;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
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
