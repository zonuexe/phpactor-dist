<?php

namespace Phpactor\WorseReflection\Core;

use Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor\WorseReflection\Core\Type\SelfType;
use Phpactor\WorseReflection\Core\Type\StaticType;
use Phpactor\WorseReflection\Core\Type\ThisType;
final class MemberTypeContextualiser
{
    public function contextualise(ReflectionClassLike $declaringClass, ReflectionClassLike $class, \Phpactor\WorseReflection\Core\Type $type) : \Phpactor\WorseReflection\Core\Type
    {
        return $type->map(function (\Phpactor\WorseReflection\Core\Type $type) use($class, $declaringClass) {
            if ($type instanceof ThisType) {
                return new ThisType($class->type());
            }
            if ($type instanceof StaticType) {
                return new StaticType($class->type());
            }
            if ($type instanceof SelfType) {
                return new SelfType($declaringClass->type());
            }
            return $type;
        });
    }
}
