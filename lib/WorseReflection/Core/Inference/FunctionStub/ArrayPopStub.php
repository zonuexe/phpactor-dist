<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayLiteral;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IterableType;
class ArrayPopStub implements FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext
    {
        $arg = $args->at(0);
        $argType = $arg->type();
        if (!$argType->isArray()) {
            return $context;
        }
        if ($argType instanceof ArrayLiteral) {
            $types = $argType->types();
            $poped = \array_pop($types);
            if (null === $poped) {
                return $context->withType(TypeFactory::null());
            }
            return $context->withType($poped);
        }
        $type = TypeFactory::mixed();
        if ($argType instanceof IterableType) {
            $type = $argType->iterableValueType();
        }
        return $context->withType(TypeFactory::union($type, TypeFactory::null()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArrayPopStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArrayPopStub', \false);
