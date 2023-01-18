<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
interface ReflectionFunction extends ReflectionFunctionLike
{
    public function sourceCode() : SourceCode;
    public function name() : Name;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionFunction', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionFunction', \false);
