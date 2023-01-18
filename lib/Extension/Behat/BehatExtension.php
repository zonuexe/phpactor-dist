<?php

namespace Phpactor202301\Phpactor\Extension\Behat;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\OptionalExtension;
use Phpactor202301\Phpactor\Extension\Behat\Adapter\Symfony\SymfonyDiContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Adapter\Worse\WorseContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Adapter\Worse\WorseStepFactory;
use Phpactor202301\Phpactor\Extension\Behat\Behat\BehatConfig;
use Phpactor202301\Phpactor\Extension\Behat\Behat\ContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Behat\ContextClassResolver\ChainContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepGenerator;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepParser;
use Phpactor202301\Phpactor\Extension\Behat\Completor\FeatureStepCompletor;
use Phpactor202301\Phpactor\Extension\Behat\ReferenceFinder\StepDefinitionLocator;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class BehatExtension implements OptionalExtension
{
    const PARAM_CONFIG_PATH = 'behat.config_path';
    const PARAM_SYMFONY_XML_PATH = 'behat.symfony.di_xml_path';
    public function load(ContainerBuilder $container) : void
    {
        $container->register('behat.step_factory', function (Container $container) {
            return new WorseStepFactory($container->get(WorseReflectionExtension::SERVICE_REFLECTOR), $container->get(ContextClassResolver::class));
        });
        $container->register('behat.step_generator', function (Container $container) {
            return new StepGenerator($container->get('behat.config'), $container->get('behat.step_factory'), $container->get('behat.step_parser'));
        });
        $container->register('behat.step_parser', function (Container $container) {
            return new StepParser();
        });
        $container->register('behat.config', function (Container $container) {
            return new BehatConfig($container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER)->resolve($container->getParameter(self::PARAM_CONFIG_PATH)));
        });
        $container->register('behat.completion.feature_step_completor', function (Container $container) {
            return new FeatureStepCompletor($container->get('behat.step_generator'), $container->get('behat.step_parser'));
        }, [CompletionExtension::TAG_COMPLETOR => [CompletionExtension::KEY_COMPLETOR_TYPES => ['cucumber']]]);
        $container->register('behat.reference_finder.step_definition_locator', function (Container $container) {
            return new StepDefinitionLocator($container->get('behat.step_generator'), $container->get('behat.step_parser'));
        }, [ReferenceFinderExtension::TAG_DEFINITION_LOCATOR => []]);
        $container->register(ContextClassResolver::class, function (Container $container) {
            $resolvers = [new WorseContextClassResolver($container->get(WorseReflectionExtension::SERVICE_REFLECTOR))];
            if (null !== ($symfonyXmlPath = $container->getParameter(self::PARAM_SYMFONY_XML_PATH))) {
                $resolvers[] = new SymfonyDiContextClassResolver($symfonyXmlPath);
            }
            return new ChainContextClassResolver($resolvers);
        });
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::PARAM_CONFIG_PATH => '%project_root%/behat.yml', self::PARAM_SYMFONY_XML_PATH => null]);
        $schema->setDescriptions([self::PARAM_CONFIG_PATH => 'Path to the main behat.yml (including the filename behat.yml)', self::PARAM_SYMFONY_XML_PATH => 'If using Symfony, set this path to the XML container dump to find contexts which are defined as services']);
    }
    public function name() : string
    {
        return 'behat';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\BehatExtension', 'Phpactor\\Extension\\Behat\\BehatExtension', \false);
