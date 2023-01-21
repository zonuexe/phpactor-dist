<?php

namespace Phpactor\LanguageServer\Core\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServerProtocol\Range;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
use function Phpactor202301\Amp\call;
use function Phpactor202301\Amp\delay;
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
