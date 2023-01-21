<?php

namespace Phpactor\Container;

use Phpactor\MapResolver\Resolver;
interface Extension
{
    /**
     * Register services with the container.
     */
    public function load(\Phpactor\Container\ContainerBuilder $container) : void;
    /**
     * Return the default parameters for the container.
     */
    public function configure(Resolver $schema) : void;
}
