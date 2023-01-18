<?php

namespace Phpactor202301\Phpactor\Extension\Console\Tests\Unit\Example;

use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class InvalidExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('test.command.test', function () {
            return new TestCommand();
        }, [ConsoleExtension::TAG_COMMAND => []]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Console\\Tests\\Unit\\Example\\InvalidExtension', 'Phpactor\\Extension\\Console\\Tests\\Unit\\Example\\InvalidExtension', \false);
