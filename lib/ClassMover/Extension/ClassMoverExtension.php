<?php

namespace Phpactor202301\Phpactor\ClassMover\Extension;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\ClassMover\Adapter\TolerantParser\TolerantClassFinder;
use Phpactor202301\Phpactor\ClassMover\Adapter\TolerantParser\TolerantClassReplacer;
use Phpactor202301\Phpactor\ClassMover\ClassMover;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Container\Container;
class ClassMoverExtension implements Extension
{
    public function configure(Resolver $schema) : void
    {
    }
    public function load(ContainerBuilder $container) : void
    {
        $this->registerClassMover($container);
    }
    private function registerClassMover(ContainerBuilder $container) : void
    {
        $container->register(ClassMover::class, function (Container $container) {
            return new ClassMover($container->get('class_mover.class_finder'), $container->get('class_mover.ref_replacer'));
        });
        $container->register('class_mover.class_finder', function (Container $container) {
            return new TolerantClassFinder();
        });
        $container->register('class_mover.ref_replacer', function (Container $container) {
            return new TolerantClassReplacer($container->get(Updater::class));
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Extension\\ClassMoverExtension', 'Phpactor\\ClassMover\\Extension\\ClassMoverExtension', \false);
