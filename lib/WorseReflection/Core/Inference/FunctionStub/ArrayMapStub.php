<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClosureType;
class ArrayMapStub implements FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext
    {
        if (!$args->at(0)->type()->isDefined()) {
            return $context;
        }
        $closureType = $args->at(0)->type();
        if (!$closureType instanceof ClosureType) {
            return $context;
        }
        return $context->withType(TypeFactory::array($closureType->returnType()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArrayMapStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\ArrayMapStub', \false);
