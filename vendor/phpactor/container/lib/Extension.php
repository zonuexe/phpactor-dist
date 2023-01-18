<?php

namespace Phpactor202301\Phpactor\Container;

use Phpactor202301\Phpactor\MapResolver\Resolver;
interface Extension
{
    /**
     * Register services with the container.
     */
    public function load(ContainerBuilder $container) : void;
    /**
     * Return the default parameters for the container.
     */
    public function configure(Resolver $schema) : void;
}
\class_alias('Phpactor202301\\Phpactor\\Container\\Extension', 'Phpactor\\Container\\Extension', \false);
