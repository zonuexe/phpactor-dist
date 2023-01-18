<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Registry;

use Phpactor202301\Phpactor\Extension\Rpc\Exception\HandlerNotFound;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\HandlerRegistry;
use Phpactor202301\Psr\Container\ContainerInterface;
class LazyContainerHandlerRegistry implements HandlerRegistry
{
    public function __construct(private ContainerInterface $container, private array $serviceMap)
    {
    }
    public function get($handlerName) : Handler
    {
        if (!isset($this->serviceMap[$handlerName])) {
            if (\false === isset($this->serviceMap[$handlerName])) {
                throw new HandlerNotFound(\sprintf('No handler "%s", available handlers: "%s"', $handlerName, \implode('", "', \array_keys($this->serviceMap))));
            }
        }
        return $this->container->get($this->serviceMap[$handlerName]);
    }
    public function all() : array
    {
        return \array_map(function (string $serviceId) {
            return $this->container->get($serviceId);
        }, $this->serviceMap);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Registry\\LazyContainerHandlerRegistry', 'Phpactor\\Extension\\Rpc\\Registry\\LazyContainerHandlerRegistry', \false);
