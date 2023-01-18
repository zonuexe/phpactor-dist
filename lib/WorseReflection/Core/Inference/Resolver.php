<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

use Phpactor202301\Microsoft\PhpParser\Node;
interface Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver', \false);
