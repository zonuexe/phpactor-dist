<?php

namespace Phpactor\Completion\Bridge\TolerantParser;

use PhpactorDist\Microsoft\PhpParser\Node;
interface TolerantQualifier
{
    /**
     * Return a node which can be completed on or
     * null if it does not qualify.
     */
    public function couldComplete(Node $node) : ?Node;
}
