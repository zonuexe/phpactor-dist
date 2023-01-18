<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayLiteral;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class ArrayMergeStub implements FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext
    {
        $types = [];
        $isLiteralSet = \true;
        $typeMap = [];
        foreach ($args as $arg) {
            $type = $arg->type();
            if (!$type instanceof ArrayLiteral) {
                $isLiteralSet = \false;
                break;
            }
            $typeMap = \array_merge($typeMap, $type->types());
        }
        if ($isLiteralSet) {
            return $context->withType(TypeFactory::arrayLiteral($typeMap));
        }
        $keys = $values = [];
        foreach ($args as $arg) {
            $type = $arg->type();
            if (!$type instanceof ArrayType) {
                continue;
            }
            $keys[] = $type->iterableKeyType();
            $values[] = $type->iterableValueType();
        }
        if ($values) {
            return $context->withType(new ArrayType(TypeFactory::union(...$keys), TypeFactory::union(...$values)));
        }
        return $context->withType(TypeUtil::generalTypeFromTypes($types));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArrayMergeStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArrayMergeStub', \false);
