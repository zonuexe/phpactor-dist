<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\TypeResolver;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class FunctionReturnTypeResolver
{
    public function __construct(private ReflectionFunction $function)
    {
    }
    public function resolve() : Type
    {
        return TypeUtil::firstDefined($this->getDocblockTypeFromFunction($this->function), $this->function->type());
    }
    private function getDocblockTypeFromFunction(ReflectionFunction $function) : Type
    {
        return $function->docblock()->returnType();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\TypeResolver\\FunctionReturnTypeResolver', 'Phpactor\\WorseReflection\\Core\\Reflection\\TypeResolver\\FunctionReturnTypeResolver', \false);
