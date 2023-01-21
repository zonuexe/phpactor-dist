<?php

namespace Phpactor\WorseReflection\Core\Reflection;

interface ReflectionProperty extends \Phpactor\WorseReflection\Core\Reflection\ReflectionMember
{
    public function isStatic() : bool;
    public function isPromoted() : bool;
}
