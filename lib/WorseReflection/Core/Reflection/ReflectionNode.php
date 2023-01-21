<?php

namespace Phpactor\WorseReflection\Core\Reflection;

interface ReflectionNode
{
    public function scope() : \Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
}
