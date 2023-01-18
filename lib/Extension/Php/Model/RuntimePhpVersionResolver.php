<?php

namespace Phpactor202301\Phpactor\Extension\Php\Model;

class RuntimePhpVersionResolver implements PhpVersionResolver
{
    public function resolve() : ?string
    {
        return \phpversion();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\Model\\RuntimePhpVersionResolver', 'Phpactor\\Extension\\Php\\Model\\RuntimePhpVersionResolver', \false);
