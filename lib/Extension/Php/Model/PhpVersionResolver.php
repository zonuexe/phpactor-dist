<?php

namespace Phpactor202301\Phpactor\Extension\Php\Model;

interface PhpVersionResolver
{
    /**
     * @return string
     */
    public function resolve() : ?string;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\Model\\PhpVersionResolver', 'Phpactor\\Extension\\Php\\Model\\PhpVersionResolver', \false);
