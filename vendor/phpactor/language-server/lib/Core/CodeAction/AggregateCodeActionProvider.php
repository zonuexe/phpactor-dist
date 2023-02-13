<?php

namespace Phpactor\LanguageServer\Core\CodeAction;

use PhpactorDist\Amp\CancellationToken;
use PhpactorDist\Amp\Promise;
use Phpactor\LanguageServerProtocol\Range;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
use function PhpactorDist\Amp\call;
use function PhpactorDist\Amp\delay;
class AggregateCodeActionProvider implements \Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider
{
    /**
     * @var CodeActionProvider[]
     */
    private array $providers;
    public function __construct(\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider ...$providers)
    {
        $this->providers = $providers;
    }
    /**
     * {@inheritDoc}
     */
    public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
    {
        return call(function () use($textDocument, $range, $cancel) {
            $actions = [];
            foreach ($this->providers as $provider) {
                $actions = \array_merge($actions, (yield $provider->provideActionsFor($textDocument, $range, $cancel)));
                (yield delay(0));
                $cancel->throwIfRequested();
            }
            return $actions;
        });
    }
    /**
     * {@inheritDoc}
     */
    public function kinds() : array
    {
        return \array_values(\array_reduce($this->providers, function (array $kinds, \Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider $provider) {
            return \array_merge($kinds, (array) \array_combine($provider->kinds(), $provider->kinds()));
        }, []));
    }
}
