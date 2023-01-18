<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerHover\Twig\Functions;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class TypeShortName
{
    public function __invoke(Type $type) : string
    {
        return TypeUtil::shortenClassTypes($type);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerHover\\Twig\\Functions\\TypeShortName', 'Phpactor\\Extension\\LanguageServerHover\\Twig\\Functions\\TypeShortName', \false);
