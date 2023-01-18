#!/usr/bin/env php
<?php 
namespace Phpactor202301;

use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServer\Core\Middleware\RequestHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Middleware\ClosureMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher\MiddlewareDispatcher;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter\MessageTransmitter;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Factory\ClosureDispatcherFactory;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerBuilder;
require __DIR__ . '/../../vendor/autoload.php';
$builder = LanguageServerBuilder::create(new ClosureDispatcherFactory(function (MessageTransmitter $transmitter, InitializeParams $params) {
    return new MiddlewareDispatcher(new ClosureMiddleware(function (Message $message, RequestHandler $handler) {
        if (!$message instanceof RequestMessage) {
            return $handler->handle($message);
        }
        return new Success(new ResponseMessage($message->id, 'Hello World!'));
    }));
}));
$builder->build()->run();
