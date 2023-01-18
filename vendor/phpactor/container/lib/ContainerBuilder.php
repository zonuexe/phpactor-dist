<?php

namespace Phpactor202301\Phpactor\Container;

use Closure;
interface ContainerBuilder
{
    /**
     * @param array<string,array<string,mixed>> $tags
     * @param Closure(Container):mixed $service
     */
    public function register(string $serviceId, Closure $service, array $tags = []) : void;
    /**
     * @param array<string,mixed> $parameters
     */
    public function build(array $parameters) : Container;
}
\class_alias('Phpactor202301\\Phpactor\\Container\\ContainerBuilder', 'Phpactor\\Container\\ContainerBuilder', \false);
