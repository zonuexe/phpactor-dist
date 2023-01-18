<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\CodeAction;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use function Phpactor202301\Amp\call;
use function Phpactor202301\Amp\delay;
class AggregateCodeActionProvider implements CodeActionProvider
{
    /**
     * @var CodeActionProvider[]
     */
    private array $providers;
    public function __construct(CodeActionProvider ...$providers)
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
        return \array_values(\array_reduce($this->providers, function (array $kinds, CodeActionProvider $provider) {
            return \array_merge($kinds, (array) \array_combine($provider->kinds(), $provider->kinds()));
        }, []));
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\CodeAction\\AggregateCodeActionProvider', 'Phpactor\\LanguageServer\\Core\\CodeAction\\AggregateCodeActionProvider', \false);
