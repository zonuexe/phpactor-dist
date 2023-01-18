<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\DiagnosticProvider\WorseDiagnosticProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\SourceLocator\WorkspaceSourceLocator;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Workspace\WorkspaceIndex;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Workspace\WorkspaceIndexListener;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class LanguageServerWorseReflectionExtension implements Extension
{
    const PARAM_UPDATE_INTERVAL = 'language_server_worse_reflection.workspace_index.update_interval';
    public function load(ContainerBuilder $container) : void
    {
        $this->registerSourceLocator($container);
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::PARAM_UPDATE_INTERVAL => 100]);
        $schema->setDescriptions([self::PARAM_UPDATE_INTERVAL => 'Minimum interval to update the workspace index as documents are updated (in milliseconds)']);
    }
    private function registerSourceLocator(ContainerBuilder $container) : void
    {
        $container->register(WorkspaceSourceLocator::class, function (Container $container) {
            return new WorkspaceSourceLocator($container->get(WorkspaceIndex::class));
        }, [WorseReflectionExtension::TAG_SOURCE_LOCATOR => ['priority' => 255]]);
        $container->register(WorkspaceIndexListener::class, function (Container $container) {
            return new WorkspaceIndexListener($container->get(WorkspaceIndex::class));
        }, [LanguageServerExtension::TAG_LISTENER_PROVIDER => []]);
        $container->register(WorkspaceIndex::class, function (Container $container) {
            return new WorkspaceIndex(ReflectorBuilder::create()->build(), $container->getParameter(self::PARAM_UPDATE_INTERVAL));
        });
        $container->register(WorseDiagnosticProvier::class, function (Container $container) {
            return new WorseDiagnosticProvider($container->get(WorseReflectionExtension::SERVICE_REFLECTOR));
        }, [LanguageServerExtension::TAG_DIAGNOSTICS_PROVIDER => []]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\LanguageServerWorseReflectionExtension', 'Phpactor\\Extension\\LanguageServerWorseReflection\\LanguageServerWorseReflectionExtension', \false);
