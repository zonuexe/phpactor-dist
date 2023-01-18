<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Virtual;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionProperty;
class VirtualReflectionProperty extends VirtualReflectionMember implements ReflectionProperty
{
    public function isVirtual() : bool
    {
        return \true;
    }
    public function isStatic() : bool
    {
        return \false;
    }
    public function memberType() : string
    {
        return ReflectionMember::TYPE_PROPERTY;
    }
    public function isPromoted() : bool
    {
        return \false;
    }
    public function withClass(ReflectionClassLike $class) : ReflectionMember
    {
        $new = clone $this;
        $new->class = $class;
        return $new;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Virtual\\VirtualReflectionProperty', 'Phpactor\\WorseReflection\\Core\\Virtual\\VirtualReflectionProperty', \false);
