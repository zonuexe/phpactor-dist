<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype;

final class NamespaceName extends QualifiedName
{
    public static function root() : NamespaceName
    {
        return new self('');
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\Prototype\\NamespaceName', 'Phpactor\\CodeBuilder\\Domain\\Prototype\\NamespaceName', \false);
