<?php

namespace Phpactor202301\Phpactor\Extension\Symfony;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\OptionalExtension;
use Phpactor202301\Phpactor\Extension\CompletionWorse\CompletionWorseExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Symfony\Adapter\Symfony\XmlSymfonyContainerInspector;
use Phpactor202301\Phpactor\Extension\Symfony\Completor\SymfonyContainerCompletor;
use Phpactor202301\Phpactor\Extension\Symfony\Model\SymfonyContainerInspector;
use Phpactor202301\Phpactor\Extension\Symfony\WorseReflection\SymfonyContainerContextResolver;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class SymfonyExtension implements OptionalExtension
{
    const XML_PATH = 'symfony.xml_path';
    const PARAM_COMPLETOR_ENABLED = 'completion_worse.completor.symfony.enabled';
    public function load(ContainerBuilder $container) : void
    {
        $container->register(SymfonyContainerInspector::class, function (Container $container) {
            $xmlPath = $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER)->resolve($container->getParameter(self::XML_PATH));
            return new XmlSymfonyContainerInspector($xmlPath);
        });
        $container->register(SymfonyContainerCompletor::class, function (Container $container) {
            return new SymfonyContainerCompletor($container->get(WorseReflectionExtension::SERVICE_REFLECTOR), $container->get(SymfonyContainerInspector::class));
        }, [CompletionWorseExtension::TAG_TOLERANT_COMPLETOR => ['name' => 'symfony']]);
        $container->register(SymfonyContainerContextResolver::class, function (Container $container) {
            return new SymfonyContainerContextResolver($container->get(SymfonyContainerInspector::class));
        }, [WorseReflectionExtension::TAG_MEMBER_TYPE_RESOLVER => []]);
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::XML_PATH => '%project_root%/var/cache/dev/App_KernelDevDebugContainer.xml', self::PARAM_COMPLETOR_ENABLED => \true]);
        $schema->setDescriptions([self::XML_PATH => 'Path to the Symfony container XML dump file', self::PARAM_COMPLETOR_ENABLED => 'Enable/disable the Symfony completor - depends on Symfony extension being enabled']);
    }
    public function name() : string
    {
        return 'symfony';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Symfony\\SymfonyExtension', 'Phpactor\\Extension\\Symfony\\SymfonyExtension', \false);
