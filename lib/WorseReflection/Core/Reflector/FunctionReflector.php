<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflector;

use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
interface FunctionReflector
{
    /**
     * @param string|Name $name
     */
    public function reflectFunction($name) : ReflectionFunction;
    /**
     * @param string|Name $name
     */
    public function sourceCodeForFunction($name) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflector\\FunctionReflector', 'Phpactor\\WorseReflection\\Core\\Reflector\\FunctionReflector', \false);
