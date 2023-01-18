<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Closure;
use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Types;
final class NullableType extends Type implements HasEmptyType
{
    public function __construct(public Type $type)
    {
    }
    public function __toString() : string
    {
        return '?' . $this->type->__toString();
    }
    public function toPhpString() : string
    {
        return '?' . $this->type->toPhpString();
    }
    public function accepts(Type $type) : Trinary
    {
        if ($type instanceof NullableType) {
            return Trinary::true();
        }
        return $this->type->accepts($type);
    }
    public function expandTypes() : Types
    {
        return new Types([new NullType(), $this->type]);
    }
    public function allTypes() : Types
    {
        $types = new Types([]);
        foreach ($this->expandTypes() as $type) {
            $types = $types->merge($type->allTypes());
        }
        return $types;
    }
    public function isNull() : bool
    {
        return \true;
    }
    public function isNullable() : bool
    {
        return \true;
    }
    public function stripNullable() : Type
    {
        return $this->type;
    }
    public function emptyType() : Type
    {
        return $this;
    }
    public function map(Closure $mapper) : Type
    {
        return new NullableType($mapper($this->type));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\NullableType', 'Phpactor\\WorseReflection\\Core\\Type\\NullableType', \false);
