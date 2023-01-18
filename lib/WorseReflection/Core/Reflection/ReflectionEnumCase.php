<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface ReflectionEnumCase extends ReflectionMember
{
    public function value() : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionEnumCase', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionEnumCase', \false);
