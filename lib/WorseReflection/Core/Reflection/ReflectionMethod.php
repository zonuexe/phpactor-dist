<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface ReflectionMethod extends ReflectionMember, ReflectionFunctionLike
{
    /**
     * @deprecated - use type()
     */
    public function returnType() : Type;
    public function isAbstract() : bool;
    public function isStatic() : bool;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionMethod', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionMethod', \false);
