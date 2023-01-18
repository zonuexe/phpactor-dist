<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ClassReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class EnumCaseType extends ReflectedClassType implements ClassLikeType
{
    public function __construct(ClassReflector $reflector, public ClassType $enumType, public string $caseName)
    {
        parent::__construct($reflector, ClassName::fromString('UnitEnumCase'));
    }
    public function __toString() : string
    {
        return \sprintf('%s::%s', $this->enumType, $this->caseName);
    }
    public function toPhpString() : string
    {
        return $this->enumType;
    }
    public function accepts(Type $type) : Trinary
    {
        return Trinary::maybe();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\EnumCaseType', 'Phpactor\\WorseReflection\\Core\\Type\\EnumCaseType', \false);
