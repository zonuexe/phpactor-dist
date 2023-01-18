<?php

namespace Phpactor202301\Phpactor\Extension\WorseReferenceFinder;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\WorseReferenceFinder\TolerantVariableDefintionLocator;
use Phpactor202301\Phpactor\WorseReferenceFinder\WorsePlainTextClassDefinitionLocator;
use Phpactor202301\Phpactor\WorseReferenceFinder\WorseReflectionDefinitionLocator;
use Phpactor202301\Phpactor\WorseReferenceFinder\WorseReflectionTypeLocator;
use Phpactor202301\Phpactor\WorseReferenceFinder\TolerantVariableReferenceFinder;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache;
class WorseReferenceFinderExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('worse_reference_finder.definition_locator.reflection', function (Container $container) {
            return new WorseReflectionDefinitionLocator($container->get(WorseReflectionExtension::SERVICE_REFLECTOR), $container->get(Cache::class));
        }, [ReferenceFinderExtension::TAG_DEFINITION_LOCATOR => []]);
        $container->register('worse_reference_finder.type_locator.reflection', function (Container $container) {
            return new WorseReflectionTypeLocator($container->get(WorseReflectionExtension::SERVICE_REFLECTOR));
        }, [ReferenceFinderExtension::TAG_TYPE_LOCATOR => []]);
        $container->register('worse_reference_finder.definition_locator.plain_text_class', function (Container $container) {
            return new WorsePlainTextClassDefinitionLocator($container->get(WorseReflectionExtension::SERVICE_REFLECTOR));
        }, [ReferenceFinderExtension::TAG_DEFINITION_LOCATOR => []]);
        $container->register('worse_reference_finder.definition_locator.variable', function (Container $container) {
            return new TolerantVariableDefintionLocator(new TolerantVariableReferenceFinder($container->get('worse_reflection.tolerant_parser'), \true));
        }, [ReferenceFinderExtension::TAG_DEFINITION_LOCATOR => []]);
        $container->register('worse_reference_finder.reference_finder.variable', function (Container $container) {
            return new TolerantVariableReferenceFinder($container->get('worse_reflection.tolerant_parser'));
        }, [ReferenceFinderExtension::TAG_REFERENCE_FINDER => []]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReferenceFinder\\WorseReferenceFinderExtension', 'Phpactor\\Extension\\WorseReferenceFinder\\WorseReferenceFinderExtension', \false);
