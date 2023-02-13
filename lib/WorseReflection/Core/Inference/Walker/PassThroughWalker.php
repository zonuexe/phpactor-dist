<?php

namespace Phpactor\WorseReflection\Core\Inference\Walker;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\CatchClause;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\BinaryExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\CallExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\Variable;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\YieldExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\ForeachStatement;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\IfStatementNode;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\Inference\FrameResolver;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor\WorseReflection\Core\Inference\Walker;
/**
 * Temporary class to bridge to the node resolvers (originally all these
 * classes were "walkers") the goal is to remove the "walker" concept.
 */
class PassThroughWalker implements Walker
{
    public function nodeFqns() : array
    {
        return [YieldExpression::class, ReturnStatement::class, IfStatementNode::class, ForeachStatement::class, CatchClause::class, BinaryExpression::class, CallExpression::class, AssignmentExpression::class, Variable::class];
    }
    public function enter(FrameResolver $resolver, Frame $frame, Node $node) : Frame
    {
        $resolver->resolveNode($frame, $node);
        return $frame;
    }
    public function exit(FrameResolver $resolver, Frame $frame, Node $node) : Frame
    {
        return $frame;
    }
}
