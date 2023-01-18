<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

interface FunctionStub
{
    public function resolve(Frame $frame, NodeContext $context, FunctionArguments $args) : NodeContext;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStub', \false);
