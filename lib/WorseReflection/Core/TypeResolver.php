<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

interface TypeResolver
{
    public function resolve(Type $type) : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\TypeResolver', 'Phpactor\\WorseReflection\\Core\\TypeResolver', \false);
