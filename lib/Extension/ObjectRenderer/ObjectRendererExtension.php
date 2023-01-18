<?php

namespace Phpactor202301\Phpactor\Extension\ObjectRenderer;

use Phpactor202301\Phpactor\CodeBuilder\Domain\TemplatePathResolver\PhpVersionPathResolver;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ObjectRenderer\Extension\ObjectRendererTwigExtension;
use Phpactor202301\Phpactor\Extension\Php\Model\PhpVersionResolver;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use RuntimeException;
use Phpactor202301\Twig\Environment;
class ObjectRendererExtension implements Extension
{
    public const PARAM_TEMPLATE_PATHS = 'object_renderer.template_paths.markdown';
    public const SERVICE_MARKDOWN_RENDERER = 'object_renderer.renderer.markdown';
    const TAG_TWIG_EXTENSION = 'object_renderer.twig_extension';
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults([self::PARAM_TEMPLATE_PATHS => ['%project_config%/templates/markdown', '%config%/templates/markdown']]);
        $schema->setDescriptions([self::PARAM_TEMPLATE_PATHS => 'Paths in which to look for templates for hover information.']);
    }
    public function load(ContainerBuilder $container) : void
    {
        $container->register(self::SERVICE_MARKDOWN_RENDERER, function (Container $container) {
            $resolver = $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER);
            $templatePaths = $container->getParameter(self::PARAM_TEMPLATE_PATHS);
            $templatePaths[] = __DIR__ . '/../../../templates/help/markdown';
            $resolvedTemplatePaths = \array_map(function (string $path) use($resolver) {
                return $resolver->resolve($path);
            }, $templatePaths);
            $phpVersion = $container->get(PhpVersionResolver::class)->resolve();
            $paths = (new PhpVersionPathResolver($phpVersion))->resolve($resolvedTemplatePaths);
            $builder = ObjectRendererBuilder::create()->setLogger(LoggingExtension::channelLogger($container, 'LSP-HOVER'))->enableInterfaceCandidates()->enableAncestoralCandidates()->configureTwig(function (Environment $env) use($container) {
                foreach ($container->getServiceIdsForTag(self::TAG_TWIG_EXTENSION) as $serviceId => $_) {
                    $service = $container->get($serviceId);
                    if (!$service instanceof ObjectRendererTwigExtension) {
                        throw new RuntimeException(\sprintf('Expected service to be a "%s"', ObjectRendererTwigExtension::class));
                    }
                    $service->configure($env);
                }
                return $env;
            })->renderEmptyOnNotFound();
            foreach ($paths as $path) {
                $builder = $builder->addTemplatePath($path);
            }
            return $builder->build();
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ObjectRenderer\\ObjectRendererExtension', 'Phpactor\\Extension\\ObjectRenderer\\ObjectRendererExtension', \false);
