<?php

namespace Phpactor\LanguageServer\Core\Diagnostics;

use Phpactor202301\Amp\CancelledException;
use Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Deferred;
use Phpactor\LanguageServerProtocol\TextDocumentItem;
use function Phpactor202301\Amp\delay;
class DiagnosticsEngine
{
    /**
     * @var Deferred<TextDocumentItem>
     */
    private $deferred;
    /**
     * @var bool
     */
    private $running = \false;
    /**
     * @var ?TextDocumentItem
     */
    private $next;
    /**
     * @var DiagnosticsProvider
     */
    private $provider;
    /**
     * @var ClientApi
     */
    private $clientApi;
    /**
     * @var int
     */
    private $sleepTime;
    public function __construct(ClientApi $clientApi, \Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider $provider, int $sleepTime = 1000)
    {
        $this->deferred = new Deferred();
        $this->provider = $provider;
        $this->clientApi = $clientApi;
        $this->sleepTime = $sleepTime;
    }
    public function clear(TextDocumentItem $textDocument) : void
    {
        $this->clientApi->diagnostics()->publishDiagnostics($textDocument->uri, $textDocument->version, []);
    }
    /**
     * @return Promise<bool>
     */
    public function run(CancellationToken $token) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($token) {
            while (\true) {
                try {
                    $token->throwIfRequested();
                } catch (CancelledException $cancelled) {
                    return;
                }
                $textDocument = (yield $this->deferred->promise());
                $this->deferred = new Deferred();
                // after we have reset deferred, we can safely set linting to
                // `false` and let another resolve happen
                $this->running = \false;
                \assert($textDocument instanceof TextDocumentItem);
                if ($this->sleepTime > 0) {
                    (yield delay($this->sleepTime));
                }
                if ($this->next) {
                    $textDocument = $this->next;
                    $this->next = null;
                }
                $diagnostics = (yield $this->provider->provideDiagnostics($textDocument, $token));
                $this->clientApi->diagnostics()->publishDiagnostics($textDocument->uri, $textDocument->version, $diagnostics);
            }
        });
    }
    public function enqueue(TextDocumentItem $textDocument) : void
    {
        // if we are already linting then store whatever comes afterwards in
        // next, overwriting the redundant update
        if ($this->running === \true) {
            $this->next = $textDocument;
            return;
        }
        // resolving the promise will start PHPStan
        $this->running = \true;
        $this->deferred->resolve($textDocument);
    }
}
