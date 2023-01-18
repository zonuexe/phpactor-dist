<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class ReflectionConstantAccess
{
    /**
     * @param ScopedPropertyAccessExpression|MemberAccessExpression $node
     */
    public function __construct(private Node $node)
    {
    }
    public function position() : Position
    {
        return Position::fromFullStartStartAndEnd($this->node->getFullStartPosition(), $this->node->getStartPosition(), $this->node->getEndPosition());
    }
    public function name() : string
    {
        return NodeUtil::nameFromTokenOrNode($this->node, $this->node->memberName);
    }
    public function nameRange() : ByteOffsetRange
    {
        $memberName = $this->node->memberName;
        return ByteOffsetRange::fromInts($memberName->getStartPosition(), $memberName->getEndPosition());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionConstantAccess', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionConstantAccess', \false);
