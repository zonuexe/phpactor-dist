<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher;

use Phpactor202301\Amp\Deferred;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher;
use RuntimeException;
final class DeferredResponseWatcher implements ResponseWatcher
{
    /**
     * @var array<string|int, Deferred<ResponseMessage>>
     */
    private $watchers = [];
    public function handle(ResponseMessage $response) : void
    {
        if (isset($this->watchers[$response->id])) {
            $this->watchers[$response->id]->resolve($response);
            return;
        }
        throw new RuntimeException(\sprintf('Response to unknown request "%s"', $response->id));
    }
    /**
     * @param string|int $requestId
     *
     * @return Promise<ResponseMessage>
     */
    public function waitForResponse($requestId) : Promise
    {
        $deferred = new Deferred();
        $this->watchers[$requestId] = $deferred;
        return $deferred->promise();
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\ResponseWatcher\\DeferredResponseWatcher', 'Phpactor\\LanguageServer\\Core\\Server\\ResponseWatcher\\DeferredResponseWatcher', \false);
