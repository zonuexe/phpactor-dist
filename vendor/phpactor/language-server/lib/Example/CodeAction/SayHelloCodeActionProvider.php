<?php

namespace Phpactor202301\Phpactor\LanguageServer\Example\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
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
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Example\\CodeAction\\SayHelloCodeActionProvider', 'Phpactor\\LanguageServer\\Example\\CodeAction\\SayHelloCodeActionProvider', \false);
