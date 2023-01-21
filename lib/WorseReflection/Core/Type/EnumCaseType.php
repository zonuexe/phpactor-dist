<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Reflector\ClassReflector;
use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;
class EnumCaseType extends \Phpactor\WorseReflection\Core\Type\ReflectedClassType implements \Phpactor\WorseReflection\Core\Type\ClassLikeType
{
    public function __construct(ClassReflector $reflector, public \Phpactor\WorseReflection\Core\Type\ClassType $enumType, public string $caseName)
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
