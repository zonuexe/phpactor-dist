<?php

namespace Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse\Command\AnalyseCommand;
use Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse\Model\Analyser;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class WorseReflectionAnalyseExtension implements Extension
{
    public function configure(Resolver $schema) : void
    {
    }
    public function load(ContainerBuilder $container) : void
    {
        $this->registerCommands($container);
    }
    private function registerCommands(ContainerBuilder $container) : void
    {
        $container->register(AnalyseCommand::class, function (Container $container) {
            return new AnalyseCommand(new Analyser($container->get(SourceCodeFilesystemExtension::SERVICE_REGISTRY), $container->get(WorseReflectionExtension::SERVICE_REFLECTOR)));
        }, [ConsoleExtension::TAG_COMMAND => ['name' => 'worse:analyse']]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflectionAnalyse\\WorseReflectionAnalyseExtension', 'Phpactor\\Extension\\WorseReflectionAnalyse\\WorseReflectionAnalyseExtension', \false);
