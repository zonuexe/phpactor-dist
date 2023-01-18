<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Prototype;
interface TemplateNameResolver
{
    public function resolveName(Prototype $prototype) : string;
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\Twig\\TemplateNameResolver', 'Phpactor\\CodeBuilder\\Adapter\\Twig\\TemplateNameResolver', \false);
