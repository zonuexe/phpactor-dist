<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Qualifier;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
class DocblockQualifier implements TolerantQualifier
{
    public function couldComplete(Node $node) : ?Node
    {
        $docblock = $node->getLeadingCommentAndWhitespaceText();
        if (!\preg_match('{@[a-z-]+}', $docblock)) {
            return null;
        }
        return $node;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\Qualifier\\DocblockQualifier', 'Phpactor\\Completion\\Bridge\\TolerantParser\\Qualifier\\DocblockQualifier', \false);
