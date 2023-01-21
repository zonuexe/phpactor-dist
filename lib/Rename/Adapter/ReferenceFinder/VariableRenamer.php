<?php

namespace Phpactor\Rename\Adapter\ReferenceFinder;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\CatchClause;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Microsoft\PhpParser\Node\PropertyDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\UseVariableName;
use Phpactor\TextDocument\ByteOffsetRange;
class VariableRenamer extends \Phpactor\Rename\Adapter\ReferenceFinder\AbstractReferenceRenamer
{
    public function getRenameRangeForNode(Node $node) : ?ByteOffsetRange
    {
        if ($node instanceof Variable && !$node->getFirstAncestor(PropertyDeclaration::class)) {
            return $this->offsetRangeFromToken($node->name, \true);
        }
        if ($node instanceof Parameter && $node->visibilityToken) {
            return null;
        }
        if (($node instanceof Parameter || $node instanceof UseVariableName || $node instanceof CatchClause) && $node->variableName !== null) {
            return $this->offsetRangeFromToken($node->variableName, \true);
        }
        return null;
    }
}
