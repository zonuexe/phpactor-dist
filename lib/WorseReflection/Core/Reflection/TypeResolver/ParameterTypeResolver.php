<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\TypeResolver;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionParameter;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class ParameterTypeResolver
{
    public function __construct(private ReflectionParameter $parameter)
    {
    }
    public function resolve() : Type
    {
        $docblock = $this->parameter->method()->docblock();
        $docblockType = $docblock->parameterType($this->parameter->name());
        return TypeUtil::firstDefined($docblockType, $this->parameter->type());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\TypeResolver\\ParameterTypeResolver', 'Phpactor\\WorseReflection\\Core\\Reflection\\TypeResolver\\ParameterTypeResolver', \false);
