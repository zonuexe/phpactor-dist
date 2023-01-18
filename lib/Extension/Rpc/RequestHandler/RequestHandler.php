<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;

use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\Rpc\HandlerRegistry;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler as CoreRequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\Response;
class RequestHandler implements CoreRequestHandler
{
    public function __construct(private HandlerRegistry $registry)
    {
    }
    public function handle(Request $request) : Response
    {
        $counterActions = [];
        $handler = $this->registry->get($request->name());
        $resolver = new Resolver();
        $parameters = $request->parameters();
        $defaults = $handler->configure($resolver);
        $arguments = $resolver->resolve($parameters);
        return $handler->handle($arguments);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\RequestHandler\\RequestHandler', 'Phpactor\\Extension\\Rpc\\RequestHandler\\RequestHandler', \false);
