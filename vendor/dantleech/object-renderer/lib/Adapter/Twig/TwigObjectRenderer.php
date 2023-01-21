<?php

namespace Phpactor\ObjectRenderer\Adapter\Twig;

use Phpactor\ObjectRenderer\Adapter\Twig\Extension\ObjectRendererExtension;
use Phpactor\ObjectRenderer\Model\Exception\CouldNotRenderObject;
use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
use Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor202301\Twig\Environment;
use Phpactor202301\Twig\Error\LoaderError;
class TwigObjectRenderer implements ObjectRenderer
{
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var TemplateCandidateProvider
     */
    private $templateProvider;
    public function __construct(Environment $environment, TemplateCandidateProvider $templateProvider)
    {
        $environment->addExtension(new ObjectRendererExtension($this));
        $this->environment = $environment;
        $this->templateProvider = $templateProvider;
    }
    public function render(object $object) : string
    {
        $templates = $this->templateProvider->resolveFor(\get_class($object));
        foreach ($templates as $template) {
            try {
                return $this->environment->render($template, ['object' => $object]);
            } catch (LoaderError $error) {
                $errors[] = $error->getMessage();
                continue;
            }
        }
        throw new CouldNotRenderObject(\sprintf('Could not render object "%s" using templates "%s"', \get_class($object), \implode('", "', $templates)));
    }
}
