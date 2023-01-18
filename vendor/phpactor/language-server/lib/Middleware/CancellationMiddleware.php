<?php

namespace Phpactor202301\Phpactor\LanguageServer\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\MethodRunner;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\Middleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use RuntimeException;
class CancellationMiddleware implements Middleware
{
    const METHOD_CANCEL_REQUEST = '$/cancelRequest';
    /**
     * @var MethodRunner
     */
    private $runner;
    public function __construct(MethodRunner $runner)
    {
        $this->runner = $runner;
    }
    /**
     * {@inheritDoc}
     */
    public function process(Message $message, RequestHandler $handler) : Promise
    {
        if ($message instanceof NotificationMessage && $message->method === self::METHOD_CANCEL_REQUEST) {
            $id = $message->params['id'] ?? null;
            if (null === $id) {
                throw new RuntimeException('ID parameter not present in cancel notification');
            }
            $this->runner->cancelRequest($id);
            return new Success(null);
        }
        return $handler->handle($message);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Middleware\\CancellationMiddleware', 'Phpactor\\LanguageServer\\Middleware\\CancellationMiddleware', \false);
