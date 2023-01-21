<?php

namespace Phpactor\LanguageServer\Middleware;

use Phpactor202301\Amp\Promise;
use Closure;
use Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor\LanguageServer\Core\Rpc\Message;
class ClosureMiddleware implements Middleware
{
    /**
     * @var Closure
     */
    private $closure;
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }
    /**
     * {@inheritDoc}
     */
    public function process(Message $request, RequestHandler $handler) : Promise
    {
        return $this->closure->__invoke($request, $handler);
    }
}
