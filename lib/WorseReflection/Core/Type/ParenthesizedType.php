<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Closure;
use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Types;
class ParenthesizedType extends Type
{
    public function __construct(public Type $type)
    {
    }
    public function __toString() : string
    {
        return \sprintf('(%s)', $this->type->__toString());
    }
    public function toPhpString() : string
    {
        return $this->type->toPhpString();
    }
    public function accepts(Type $type) : Trinary
    {
        return $this->type->accepts($type);
    }
    public function reduce() : Type
    {
        return $this->type;
    }
    /**
     * @return Types<Type>
     */
    public function expandTypes() : Types
    {
        return $this->type->expandTypes();
    }
    public function allTypes() : Types
    {
        return $this->type->allTypes();
    }
    public function map(Closure $mapper) : Type
    {
        return new self($this->type->map($mapper));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ParenthesizedType', 'Phpactor\\WorseReflection\\Core\\Type\\ParenthesizedType', \false);
