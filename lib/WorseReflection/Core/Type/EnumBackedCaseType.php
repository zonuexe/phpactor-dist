<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
class EnumBackedCaseType extends Type implements \Phpactor\WorseReflection\Core\Type\ClassLikeType
{
    public function __construct(public \Phpactor\WorseReflection\Core\Type\ClassType $enumType, public string $name, public Type $value)
    {
    }
    public function __toString() : string
    {
        return \sprintf('%s::%s', $this->enumType, $this->name);
    }
    public function toPhpString() : string
    {
        return $this->enumType;
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::maybe();
    }
    public function name() : ClassName
    {
        return ClassName::fromString('BackedEnumCase');
    }
    public function members() : ReflectionMemberCollection
    {
        return $this->enumType->members();
    }
}
