<?php

namespace Phpactor202301\Phpactor\LanguageServer\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\MethodRunner;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
class HandlerMiddleware implements Middleware
{
    /**
     * @var MethodRunner
     */
    private $runner;
    public function __construct(MethodRunner $runner)
    {
        $this->runner = $runner;
    }
    /**
     * @return Promise<ResponseMessage|null>
     */
    public function process(Message $request, RequestHandler $handler) : Promise
    {
        if (!$request instanceof RequestMessage && !$request instanceof NotificationMessage) {
            return $handler->handle($request);
        }
        return $this->runner->dispatch($request);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Middleware\\HandlerMiddleware', 'Phpactor\\LanguageServer\\Middleware\\HandlerMiddleware', \false);
