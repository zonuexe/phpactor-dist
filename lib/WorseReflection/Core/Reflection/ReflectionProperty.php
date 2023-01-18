<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

interface ReflectionProperty extends ReflectionMember
{
    public function isStatic() : bool;
    public function isPromoted() : bool;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionProperty', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionProperty', \false);
