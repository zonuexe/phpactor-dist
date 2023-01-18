<?php

namespace Phpactor202301\Phpactor\Extension\Rpc;

use Phpactor202301\Phpactor\MapResolver\Resolver;
interface Handler
{
    public function configure(Resolver $resolver);
    public function handle(array $arguments);
    public function name() : string;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Handler', 'Phpactor\\Extension\\Rpc\\Handler', \false);
