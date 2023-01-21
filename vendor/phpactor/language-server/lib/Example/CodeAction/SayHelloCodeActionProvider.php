<?php

namespace Phpactor\LanguageServer\Example\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor\LanguageServerProtocol\Command;
use Phpactor\LanguageServerProtocol\Range;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use function Phpactor202301\Amp\call;
class SayHelloCodeActionProvider implements CodeActionProvider
{
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () {
            return [CodeAction::fromArray(['title' => 'Alice', 'command' => new Command('Hello Alice', 'phpactor.say_hello', ['Alice'])]), CodeAction::fromArray(['title' => 'Bob', 'command' => new Command('Hello Bob', 'phpactor.say_hello', ['Bob'])])];
        });
    }
    /**
     * {@inheritDoc}
     */
    public function kinds() : array
    {
        return ['example'];
    }
}
