<?php

namespace Phpactor\Extension\Rpc;

interface HandlerRegistry
{
    public function get($handlerName) : \Phpactor\Extension\Rpc\Handler;
    /** @return array<Handler> */
    public function all() : array;
}
