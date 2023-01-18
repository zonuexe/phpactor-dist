<?php

namespace Phpactor202301\Phpactor\LanguageServer\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher;
class ResponseHandlingMiddleware implements Middleware
{
    /**
     * @var ResponseWatcher
     */
    private $watcher;
    public function __construct(ResponseWatcher $watcher)
    {
        $this->watcher = $watcher;
    }
    /**
     * {@inheritDoc}
     */
    public function process(Message $request, RequestHandler $handler) : Promise
    {
        if ($request instanceof ResponseMessage) {
            $this->watcher->handle($request);
            return new Success(null);
        }
        return $handler->handle($request);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Middleware\\ResponseHandlingMiddleware', 'Phpactor\\LanguageServer\\Middleware\\ResponseHandlingMiddleware', \false);
