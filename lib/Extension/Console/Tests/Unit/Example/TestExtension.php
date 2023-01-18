<?php

namespace Phpactor202301\Phpactor\Extension\Console\Tests\Unit\Example;

use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class TestExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('test.command.test', function () {
            return new TestCommand();
        }, [ConsoleExtension::TAG_COMMAND => ['name' => 'test']]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Console\\Tests\\Unit\\Example\\TestExtension', 'Phpactor\\Extension\\Console\\Tests\\Unit\\Example\\TestExtension', \false);
