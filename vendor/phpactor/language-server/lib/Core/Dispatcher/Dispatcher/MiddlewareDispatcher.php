<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
final class MiddlewareDispatcher implements Dispatcher
{
    /**
     * @var array
     */
    private $middleware;
    public function __construct(Middleware ...$middleware)
    {
        $this->middleware = $middleware;
    }
    /**
     * {@inheritDoc}
     */
    public function dispatch(Message $request) : Promise
    {
        $handler = new RequestHandler($this->middleware);
        return $handler->handle($request);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Dispatcher\\Dispatcher\\MiddlewareDispatcher', 'Phpactor\\LanguageServer\\Core\\Dispatcher\\Dispatcher\\MiddlewareDispatcher', \false);
