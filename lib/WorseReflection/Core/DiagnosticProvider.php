<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
interface DiagnosticProvider
{
    /**
     * @return iterable<Diagnostic>
     */
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable;
    /**
     * @return iterable<Diagnostic>
     */
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DiagnosticProvider', 'Phpactor\\WorseReflection\\Core\\DiagnosticProvider', \false);
