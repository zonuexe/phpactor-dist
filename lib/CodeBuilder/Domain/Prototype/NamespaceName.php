<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class NamespaceName extends \Phpactor\CodeBuilder\Domain\Prototype\QualifiedName
{
    public static function root() : \Phpactor\CodeBuilder\Domain\Prototype\NamespaceName
    {
        return new self('');
    }
}
