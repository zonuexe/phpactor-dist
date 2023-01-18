<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Qualifier;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
class AlwaysQualfifier implements TolerantQualifier
{
    public function couldComplete(Node $node) : ?Node
    {
        return $node;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\Qualifier\\AlwaysQualfifier', 'Phpactor\\Completion\\Bridge\\TolerantParser\\Qualifier\\AlwaysQualfifier', \false);
