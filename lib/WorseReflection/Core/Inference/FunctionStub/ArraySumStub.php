<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayLiteral;
class ArraySumStub implements FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext
    {
        $arg0 = $args->at(0)->type();
        if ($arg0 instanceof ArrayLiteral) {
            $context = $context->withType(TypeFactory::fromValue(\array_sum($arg0->value())));
            return $context;
        }
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArraySumStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArraySumStub', \false);
