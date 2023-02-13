<?php

namespace Phpactor\Completion\Bridge\TolerantParser\Qualifier;

use PhpactorDist\Microsoft\PhpParser\Node;
use Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
class AlwaysQualfifier implements TolerantQualifier
{
    public function couldComplete(Node $node) : ?Node
    {
        return $node;
    }
}
