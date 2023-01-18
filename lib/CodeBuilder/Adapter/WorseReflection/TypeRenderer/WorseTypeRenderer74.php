<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\AggregateType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\BooleanType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\InvokeableType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\NullableType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\PseudoIterableType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ScalarType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\SelfType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\VoidType;
class WorseTypeRenderer74 implements WorseTypeRenderer
{
    public function render(Type $type) : ?string
    {
        if ($type instanceof NullableType) {
            return '?' . $this->render($type->type);
        }
        if ($type instanceof AggregateType) {
            return null;
        }
        if ($type instanceof ArrayType) {
            return $type->toPhpString();
        }
        if ($type instanceof BooleanType) {
            return 'bool';
        }
        if ($type instanceof ScalarType) {
            return $type->toPhpString();
        }
        if ($type instanceof ClassType) {
            return $type->short();
        }
        if ($type instanceof SelfType) {
            return $type->__toString();
        }
        if ($type instanceof VoidType) {
            return $type->__toString();
        }
        if ($type instanceof InvokeableType) {
            return $type->toPhpString();
        }
        if ($type instanceof PseudoIterableType) {
            return $type->toPhpString();
        }
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer74', 'Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer74', \false);
