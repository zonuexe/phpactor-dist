<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class EnumBackedCaseType extends Type implements ClassLikeType
{
    public function __construct(public ClassType $enumType, public string $name, public Type $value)
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
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\EnumBackedCaseType', 'Phpactor\\WorseReflection\\Core\\Type\\EnumBackedCaseType', \false);
