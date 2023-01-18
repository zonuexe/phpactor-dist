<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IterableType;
class IteratorToArrayStub implements FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext
    {
        $context = $context->withType(TypeFactory::array());
        if (!$args->at(0)->type()->isDefined()) {
            return $context;
        }
        $argType = $args->at(0)->type();
        if ($argType instanceof IterableType) {
            return $context->withType(TypeFactory::array($argType->iterableValueType()));
        }
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\IteratorToArrayStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\IteratorToArrayStub', \false);
