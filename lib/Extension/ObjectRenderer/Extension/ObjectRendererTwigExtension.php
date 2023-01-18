<?php

namespace Phpactor202301\Phpactor\Extension\ObjectRenderer\Extension;

use Phpactor202301\Twig\Environment;
interface ObjectRendererTwigExtension
{
    public function configure(Environment $env) : void;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ObjectRenderer\\Extension\\ObjectRendererTwigExtension', 'Phpactor\\Extension\\ObjectRenderer\\Extension\\ObjectRendererTwigExtension', \false);
