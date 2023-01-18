<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflector;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionDeclaredConstant;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
interface ConstantReflector
{
    /**
     * @param string|Name $name
     */
    public function reflectConstant($name) : ReflectionDeclaredConstant;
    /**
     * @param string|Name $name
     */
    public function sourceCodeForConstant($name) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflector\\ConstantReflector', 'Phpactor\\WorseReflection\\Core\\Reflector\\ConstantReflector', \false);
