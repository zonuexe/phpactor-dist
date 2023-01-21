<?php

namespace Phpactor\Extension\Php\Model;

class ConstantPhpVersionResolver implements \Phpactor\Extension\Php\Model\PhpVersionResolver
{
    public function __construct(private ?string $version)
    {
    }
    public function resolve() : ?string
    {
        return $this->version;
    }
}
