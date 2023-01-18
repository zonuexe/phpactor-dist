<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Adapter\Twig\Extension;

use Phpactor202301\Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor202301\Twig\Extension\AbstractExtension;
use Phpactor202301\Twig\TwigFunction;
class ObjectRendererExtension extends AbstractExtension
{
    /**
     * @var ObjectRenderer
     */
    private $renderer;
    public function __construct(ObjectRenderer $renderer)
    {
        $this->renderer = $renderer;
    }
    public function getFunctions()
    {
        return [new TwigFunction('render', function (?object $object) {
            if (null === $object) {
                return '';
            }
            return $this->renderer->render($object);
        })];
    }
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Adapter\\Twig\\Extension\\ObjectRendererExtension', 'Phpactor\\ObjectRenderer\\Adapter\\Twig\\Extension\\ObjectRendererExtension', \false);
