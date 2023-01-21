<?php

namespace Phpactor\Completion\Bridge\TolerantParser\Qualifier;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ClassBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\NamespaceUseClause;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\NamespaceUseDeclaration;
use Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier;
/**
 * Return true if the node is a candidate for class name completion.
 */
class ClassQualifier implements TolerantQualifier
{
    public function __construct(private int $minimumLength = 3)
    {
    }
    public function couldComplete(Node $node) : ?Node
    {
        if (\strlen($node->getText()) < $this->minimumLength) {
            return null;
        }
        if ($node instanceof QualifiedName) {
            return $node;
        }
        if ($node instanceof ObjectCreationExpression) {
            return $node;
        }
        if ($node instanceof NamespaceUseClause) {
            return $node;
        }
        if ($node instanceof NamespaceUseDeclaration) {
            return $node;
        }
        if ($node instanceof ClassBaseClause) {
            return $node;
        }
        return null;
    }
}
