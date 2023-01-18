<?php

declare (strict_types=1);
namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Tests\Extension;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\FilePathResolver\Expander\ValueExpander;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class TestExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $this->registerFilePathExpanders($container);
    }
    public function configure(Resolver $schema) : void
    {
    }
    private function registerFilePathExpanders(ContainerBuilder $container) : void
    {
        $container->register('core.file_path_resolver.project_config_expander', function (Container $container) {
            $path = $container->getParameter(FilePathResolverExtension::PARAM_PROJECT_ROOT) . '/.phpactor';
            return new ValueExpander('project_config', $path);
        }, [FilePathResolverExtension::TAG_EXPANDER => []]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Extension\\TestExtension', 'Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Extension\\TestExtension', \false);
