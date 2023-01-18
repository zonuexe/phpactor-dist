<?php

namespace Phpactor202301\Phpactor\Extension\Php\Model;

class ConstantPhpVersionResolver implements PhpVersionResolver
{
    public function __construct(private ?string $version)
    {
    }
    public function resolve() : ?string
    {
        return $this->version;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\Model\\ConstantPhpVersionResolver', 'Phpactor\\Extension\\Php\\Model\\ConstantPhpVersionResolver', \false);
