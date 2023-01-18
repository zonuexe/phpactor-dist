<?php

namespace Phpactor202301\Phpactor\Extension\Core\Rpc;

use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\InformationResponse;
class ConfigHandler implements Handler
{
    const CONFIG = 'config';
    public function __construct(private array $config)
    {
    }
    public function name() : string
    {
        return self::CONFIG;
    }
    public function configure(Resolver $resolver) : void
    {
    }
    public function handle(array $arguments)
    {
        return InformationResponse::fromString(\json_encode($this->config, \JSON_PRETTY_PRINT));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Rpc\\ConfigHandler', 'Phpactor\\Extension\\Core\\Rpc\\ConfigHandler', \false);
