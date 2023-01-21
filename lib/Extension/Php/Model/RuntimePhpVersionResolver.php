<?php

namespace Phpactor\Extension\Php\Model;

class RuntimePhpVersionResolver implements \Phpactor\Extension\Php\Model\PhpVersionResolver
{
    public function resolve() : ?string
    {
        return \phpversion();
    }
}
