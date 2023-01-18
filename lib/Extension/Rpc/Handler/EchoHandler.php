<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Handler;

use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\EchoResponse;
class EchoHandler implements Handler
{
    public function name() : string
    {
        return 'echo';
    }
    public function configure(Resolver $resolver) : void
    {
        $resolver->setRequired(['message']);
    }
    public function handle(array $arguments)
    {
        return EchoResponse::fromMessage($arguments['message']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Handler\\EchoHandler', 'Phpactor\\Extension\\Rpc\\Handler\\EchoHandler', \false);
