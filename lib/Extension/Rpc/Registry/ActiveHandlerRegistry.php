<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Registry;

use Phpactor202301\Phpactor\Extension\Rpc\Exception\HandlerNotFound;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\HandlerRegistry;
class ActiveHandlerRegistry implements HandlerRegistry
{
    private $handlers = [];
    public function __construct(array $handlers)
    {
        foreach ($handlers as $handler) {
            $this->register($handler);
        }
    }
    public function get($handlerName) : Handler
    {
        if (\false === isset($this->handlers[$handlerName])) {
            throw new HandlerNotFound(\sprintf('No handler "%s", available handlers: "%s"', $handlerName, \implode('", "', \array_keys($this->handlers))));
        }
        return $this->handlers[$handlerName];
    }
    public function all() : array
    {
        return $this->handlers;
    }
    private function register(Handler $handler) : void
    {
        $this->handlers[$handler->name()] = $handler;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Registry\\ActiveHandlerRegistry', 'Phpactor\\Extension\\Rpc\\Registry\\ActiveHandlerRegistry', \false);
