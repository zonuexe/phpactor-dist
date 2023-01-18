<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayLiteral;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IterableType;
class ResetStub implements FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext
    {
        $argType = $args->at(0)->type();
        if (!$argType->isArray()) {
            return $context;
        }
        $type = TypeFactory::mixed();
        if ($argType instanceof ArrayLiteral) {
            $type = $argType->typeAtOffset(0);
            if (!$type->isDefined()) {
                return $context->withType(TypeFactory::boolLiteral(\false));
            }
            return $context->withType($type);
        }
        if ($argType instanceof IterableType) {
            $type = $argType->iterableValueType();
        }
        return $context->withType(TypeFactory::union($type, TypeFactory::boolLiteral(\false)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ResetStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ResetStub', \false);
