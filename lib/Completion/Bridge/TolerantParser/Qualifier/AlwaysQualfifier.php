<?php

namespace Phpactor\Completion\Bridge\TolerantParser\Qualifier;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
class AlwaysQualfifier implements TolerantQualifier
{
    public function couldComplete(Node $node) : ?Node
    {
        return $node;
    }
}
