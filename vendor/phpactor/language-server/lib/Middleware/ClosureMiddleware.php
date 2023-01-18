<?php

namespace Phpactor202301\Phpactor\LanguageServer\Middleware;

use Phpactor202301\Amp\Promise;
use Closure;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
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
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Middleware\\ClosureMiddleware', 'Phpactor\\LanguageServer\\Middleware\\ClosureMiddleware', \false);
