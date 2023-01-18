<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Prototype;
final class ClassShortNameResolver implements TemplateNameResolver
{
    public function resolveName(Prototype $prototype) : string
    {
        return \basename(\str_replace('\\', '/', \get_class($prototype))) . '.php.twig';
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\Twig\\ClassShortNameResolver', 'Phpactor\\CodeBuilder\\Adapter\\Twig\\ClassShortNameResolver', \false);
