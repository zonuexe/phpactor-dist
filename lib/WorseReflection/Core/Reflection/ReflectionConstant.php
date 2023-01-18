<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

interface ReflectionConstant extends ReflectionMember
{
    /**
     * @return mixed
     */
    public function value();
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionConstant', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionConstant', \false);
