<?php

namespace Phpactor\Rename\Adapter\ReferenceFinder;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\CatchClause;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\Variable;
use PhpactorDist\Microsoft\PhpParser\Node\Parameter;
use PhpactorDist\Microsoft\PhpParser\Node\PropertyDeclaration;
use PhpactorDist\Microsoft\PhpParser\Node\UseVariableName;
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
