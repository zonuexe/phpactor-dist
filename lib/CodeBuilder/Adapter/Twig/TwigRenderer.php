<?php

namespace Phpactor\CodeBuilder\Adapter\Twig;

use Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer82;
use Phpactor\CodeBuilder\Domain\Code;
use Phpactor\CodeBuilder\Domain\Prototype\Prototype;
use Phpactor\CodeBuilder\Domain\Renderer;
use Phpactor\CodeBuilder\Util\TextFormat;
use Phpactor202301\Twig\Environment;
use Phpactor202301\Twig\Loader\FilesystemLoader;
use Phpactor202301\Twig\Error\LoaderError;
final class TwigRenderer implements Renderer
{
    private Environment $twig;
    private \Phpactor\CodeBuilder\Adapter\Twig\TemplateNameResolver $templateNameResolver;
    public function __construct(Environment $twig = null, \Phpactor\CodeBuilder\Adapter\Twig\TemplateNameResolver $templateNameResolver = null)
    {
        $this->twig = $twig ?: $this->createTwig();
        $this->templateNameResolver = $templateNameResolver ?: new \Phpactor\CodeBuilder\Adapter\Twig\ClassShortNameResolver();
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
        $twig->addExtension(new \Phpactor\CodeBuilder\Adapter\Twig\TwigExtension(new TextFormat(), new WorseTypeRenderer82()));
        return $twig;
    }
    private function twigRender(Prototype $prototype, string $templateName, string $variant = null) : string
    {
        return $this->twig->render($templateName, ['prototype' => $prototype, 'generator' => $this, 'variant' => $variant]);
    }
}
