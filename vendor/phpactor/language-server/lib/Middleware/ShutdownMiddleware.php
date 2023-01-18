<?php

namespace Phpactor202301\Phpactor\LanguageServer\Middleware;

use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ErrorCodes;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseError;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Exception\ExitSession;
use Phpactor202301\Amp\Delayed;
use Phpactor202301\Phpactor\LanguageServer\Event\WillShutdown;
use Phpactor202301\Amp\Promise;
use function Phpactor202301\Amp\call;
use Phpactor202301\Phpactor\LanguageServer\Adapter\Psr\NullEventDispatcher;
use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
final class ShutdownMiddleware implements Middleware
{
    const METHOD_SHUTDOWN = 'shutdown';
    const METHOD_EXIT = 'exit';
    private EventDispatcherInterface $eventDispatcher;
    private int $gracePeriod;
    private bool $shuttingDown = \false;
    public function __construct(?EventDispatcherInterface $eventDispatcher = null, int $gracePeriod = 500)
    {
        $this->eventDispatcher = $eventDispatcher ?: new NullEventDispatcher();
        $this->gracePeriod = $gracePeriod;
    }
    public function process(Message $request, RequestHandler $handler) : Promise
    {
        if ($request instanceof NotificationMessage) {
            if ($request->method === self::METHOD_EXIT) {
                throw new ExitSession('Exit method invoked by client');
            }
            if ($this->shuttingDown) {
                return new Success(null);
            }
        }
        if ($request instanceof RequestMessage) {
            if ($this->shuttingDown) {
                return new Success(new ResponseMessage($request->id, null, new ResponseError(ErrorCodes::InvalidRequest, 'Server is currently shutting down, cannot serve requests')));
            }
            if ($request->method === self::METHOD_SHUTDOWN) {
                $this->shuttingDown = \true;
                return $this->shutdown($request);
            }
        }
        return $handler->handle($request);
    }
    /**
     * @return Promise<null>
     */
    public function shutdown(RequestMessage $request) : Promise
    {
        return call(function () use($request) {
            $this->eventDispatcher->dispatch(new WillShutdown());
            (yield new Delayed($this->gracePeriod));
            return new ResponseMessage($request->id, null);
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Middleware\\ShutdownMiddleware', 'Phpactor\\LanguageServer\\Middleware\\ShutdownMiddleware', \false);
