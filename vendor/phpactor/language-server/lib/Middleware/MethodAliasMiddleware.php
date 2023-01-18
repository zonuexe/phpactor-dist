<?php

namespace Phpactor202301\Phpactor\LanguageServer\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
class MethodAliasMiddleware implements Middleware
{
    /**
     * @var array
     */
    private $aliasMap;
    public function __construct(array $aliasMap)
    {
        $this->aliasMap = $aliasMap;
    }
    /**
     * {@inheritDoc}
     */
    public function process(Message $request, RequestHandler $handler) : Promise
    {
        if (!$request instanceof RequestMessage && !$request instanceof NotificationMessage) {
            return $handler->handle($request);
        }
        if (isset($this->aliasMap[$request->method])) {
            $request->method = $this->aliasMap[$request->method];
        }
        return $handler->handle($request);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Middleware\\MethodAliasMiddleware', 'Phpactor\\LanguageServer\\Middleware\\MethodAliasMiddleware', \false);
