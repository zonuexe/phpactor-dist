<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser;

use Phpactor202301\Microsoft\PhpParser\Node;
interface TolerantQualifier
{
    /**
     * Return a node which can be completed on or
     * null if it does not qualify.
     */
    public function couldComplete(Node $node) : ?Node;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\TolerantQualifier', 'Phpactor\\Completion\\Bridge\\TolerantParser\\TolerantQualifier', \false);
