<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig;

use Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer82;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Prototype;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor202301\Phpactor\CodeBuilder\Util\TextFormat;
use Phpactor202301\Twig\Environment;
use Phpactor202301\Twig\Loader\FilesystemLoader;
use Phpactor202301\Twig\Error\LoaderError;
final class TwigRenderer implements Renderer
{
    private Environment $twig;
    private TemplateNameResolver $templateNameResolver;
    public function __construct(Environment $twig = null, TemplateNameResolver $templateNameResolver = null)
    {
        $this->twig = $twig ?: $this->createTwig();
        $this->templateNameResolver = $templateNameResolver ?: new ClassShortNameResolver();
    }
    public function render(Prototype $prototype, string $variant = null) : Code
    {
        $templateName = $baseTemplateName = $this->templateNameResolver->resolveName($prototype);
        if ($variant) {
            $templateName = $variant . '/' . $templateName;
        }
        try {
            $code = $this->twigRender($prototype, $templateName, $variant);
        } catch (LoaderError $error) {
            if (null === $variant) {
                throw $error;
            }
            $code = $this->twigRender($prototype, $baseTemplateName, $variant);
        }
        return Code::fromString(\rtrim($code));
    }
    private function createTwig() : Environment
    {
        $twig = new Environment(new FilesystemLoader(__DIR__ . '/../../../../templates/code'), ['strict_variables' => \true, 'autoescape' => \false]);
        $twig->addExtension(new TwigExtension(new TextFormat(), new WorseTypeRenderer82()));
        return $twig;
    }
    private function twigRender(Prototype $prototype, string $templateName, string $variant = null) : string
    {
        return $this->twig->render($templateName, ['prototype' => $prototype, 'generator' => $this, 'variant' => $variant]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\Twig\\TwigRenderer', 'Phpactor\\CodeBuilder\\Adapter\\Twig\\TwigRenderer', \false);
