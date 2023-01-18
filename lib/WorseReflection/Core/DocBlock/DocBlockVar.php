<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\DocBlock;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class DocBlockVar
{
    public function __construct(private string $name, private Type $type)
    {
    }
    public function name() : string
    {
        return $this->name;
    }
    public function type() : Type
    {
        return $this->type;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockVar', 'Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockVar', \false);
