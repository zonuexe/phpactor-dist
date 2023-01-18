<?php

namespace Phpactor202301\Phpactor\Extension\Rpc;

interface HandlerRegistry
{
    public function get($handlerName) : Handler;
    /** @return array<Handler> */
    public function all() : array;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\HandlerRegistry', 'Phpactor\\Extension\\Rpc\\HandlerRegistry', \false);
