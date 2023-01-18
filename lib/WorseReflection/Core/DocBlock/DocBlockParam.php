<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\DocBlock;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class DocBlockParam
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
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockParam', 'Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockParam', \false);
