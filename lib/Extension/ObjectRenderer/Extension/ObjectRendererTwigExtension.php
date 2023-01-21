<?php

namespace Phpactor\Extension\ObjectRenderer\Extension;

use Phpactor202301\Twig\Environment;
interface ObjectRendererTwigExtension
{
    public function configure(Environment $env) : void;
}
