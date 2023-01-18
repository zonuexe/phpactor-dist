<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\CatchClause;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\BinaryExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\YieldExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ForeachStatement;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\IfStatementNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ReturnStatement;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FrameResolver;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;
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
/**
 * Temporary class to bridge to the node resolvers (originally all these
 * classes were "walkers") the goal is to remove the "walker" concept.
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Walker\\PassThroughWalker', 'Phpactor\\WorseReflection\\Core\\Inference\\Walker\\PassThroughWalker', \false);
