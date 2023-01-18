<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
interface ReflectionSourceCode
{
    public function position() : Position;
    public function findClass(ClassName $name);
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionSourceCode', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionSourceCode', \false);
