<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher;

use Phpactor202301\Amp\Promise;
use Closure;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
final class ClosureDispatcher implements Dispatcher
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
    public function dispatch(Message $request) : Promise
    {
        return $this->closure->__invoke($request);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Dispatcher\\Dispatcher\\ClosureDispatcher', 'Phpactor\\LanguageServer\\Core\\Dispatcher\\Dispatcher\\ClosureDispatcher', \false);
