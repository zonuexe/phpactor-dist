<?php

namespace Phpactor\WorseReflection\Core\Inference;

use PhpactorDist\Microsoft\PhpParser\Node;
interface Resolver
{
    public function resolve(\Phpactor\WorseReflection\Core\Inference\NodeContextResolver $resolver, \Phpactor\WorseReflection\Core\Inference\Frame $frame, Node $node) : \Phpactor\WorseReflection\Core\Inference\NodeContext;
}
