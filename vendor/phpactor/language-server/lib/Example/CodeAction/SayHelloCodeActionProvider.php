<?php

namespace Phpactor\LanguageServer\Example\CodeAction;

use PhpactorDist\Amp\CancellationToken;
use PhpactorDist\Amp\Promise;
use Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor\LanguageServerProtocol\CodeActionKind;
use Phpactor\LanguageServerProtocol\Command;
use Phpactor\LanguageServerProtocol\Range;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use function PhpactorDist\Amp\call;
class SayHelloCodeActionProvider implements CodeActionProvider
{
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        /** @phpstan-ignore-next-line */
        return call(function () : array {
            return [CodeAction::fromArray(['title' => 'Alice', 'command' => new Command('Hello Alice', 'phpactor.say_hello', ['Alice'])]), CodeAction::fromArray(['title' => 'Bob', 'command' => new Command('Hello Bob', 'phpactor.say_hello', ['Bob'])])];
        });
    }
    /**
     * {@inheritDoc}
     */
    public function kinds() : array
    {
        return [CodeActionKind::QUICK_FIX];
    }
}
