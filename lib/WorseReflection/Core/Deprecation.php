<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

class Deprecation
{
    public function __construct(private bool $isDefined, private ?string $message = null)
    {
    }
    public function isDefined() : bool
    {
        return $this->isDefined;
    }
    public function message() : string
    {
        return $this->message ?? '';
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Deprecation', 'Phpactor\\WorseReflection\\Core\\Deprecation', \false);
