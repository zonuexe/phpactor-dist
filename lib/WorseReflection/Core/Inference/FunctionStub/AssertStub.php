<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionStub;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
class AssertStub implements FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext
    {
        $frame->applyTypeAssertions($args->at(0)->typeAssertions(), $context->symbol()->position()->end());
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\AssertStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub\\AssertStub', \false);
