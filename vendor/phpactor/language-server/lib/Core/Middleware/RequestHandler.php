<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Exception\MiddlewareTerminated;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
final class RequestHandler
{
    /**
     * @var array<Middleware>
     */
    private $queue;
    public function __construct(array $queue = [])
    {
        $this->queue = $queue;
    }
    /**
     * @return Promise<ResponseMessage|null>
     */
    public function handle(Message $request) : Promise
    {
        $middleware = \array_shift($this->queue);
        if (!$middleware) {
            throw new MiddlewareTerminated('Middleware terminated (no middleware handled the request)');
        }
        \assert($middleware instanceof Middleware);
        return $middleware->process($request, $this);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Middleware\\RequestHandler', 'Phpactor\\LanguageServer\\Core\\Middleware\\RequestHandler', \false);
