<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerHover\Twig;

use Phpactor202301\Phpactor\Extension\LanguageServerHover\Twig\Functions\TypeShortName;
use Phpactor202301\Phpactor\Extension\LanguageServerHover\Twig\Functions\TypeType;
use Phpactor202301\Phpactor\Extension\ObjectRenderer\Extension\ObjectRendererTwigExtension;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Twig\Environment;
use Phpactor202301\Twig\TwigFunction;
final class TwigFunctions implements ObjectRendererTwigExtension
{
    public function configure(Environment $env) : void
    {
        $env->addFunction(new TwigFunction('typeShortName', new TypeShortName()));
        $env->addFunction(new TwigFunction('typeDefined', function (Type $type) {
            return $type->isDefined();
        }));
        $env->addFunction(new TwigFunction('class', function ($type) {
            return \get_class($type);
        }));
        $env->addFunction(new TwigFunction('typeType', new TypeType()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerHover\\Twig\\TwigFunctions', 'Phpactor\\Extension\\LanguageServerHover\\Twig\\TwigFunctions', \false);
