<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBlackfire\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBlackfire\BlackfireProfiler;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use function Phpactor202301\Amp\call;
class BlackfireMiddleware implements Middleware
{
    public function __construct(private BlackfireProfiler $profiler)
    {
    }
    public function process(Message $request, RequestHandler $handler) : Promise
    {
        return call(function () use($request, $handler) {
            if (!$this->profiler->started()) {
                return $handler->handle($request);
            }
            $this->profiler->enable();
            $response = (yield $handler->handle($request));
            if ($this->profiler->started()) {
                $this->profiler->disable();
            }
            return $response;
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBlackfire\\Middleware\\BlackfireMiddleware', 'Phpactor\\Extension\\LanguageServerBlackfire\\Middleware\\BlackfireMiddleware', \false);
