<?php

namespace Phpactor\WorseReflection\Core\Inference;

interface FunctionStub
{
    public function resolve(\Phpactor\WorseReflection\Core\Inference\Frame $frame, \Phpactor\WorseReflection\Core\Inference\NodeContext $context, \Phpactor\WorseReflection\Core\Inference\FunctionArguments $args) : \Phpactor\WorseReflection\Core\Inference\NodeContext;
}
