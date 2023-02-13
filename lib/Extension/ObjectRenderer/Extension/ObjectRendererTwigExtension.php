<?php

namespace Phpactor\Extension\ObjectRenderer\Extension;

use PhpactorDist\Twig\Environment;
interface ObjectRendererTwigExtension
{
    public function configure(Environment $env) : void;
}
