<?php

namespace Phpactor\WorseReflection\Core\Inference;

use Phpactor202301\Microsoft\PhpParser\Node;
interface Resolver
{
    public function resolve(\Phpactor\WorseReflection\Core\Inference\NodeContextResolver $resolver, \Phpactor\WorseReflection\Core\Inference\Frame $frame, Node $node) : \Phpactor\WorseReflection\Core\Inference\NodeContext;
}
