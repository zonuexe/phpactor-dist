<?php

namespace Phpactor\DocblockParser\Ast;

class ConditionalNode extends \Phpactor\DocblockParser\Ast\TypeNode
{
    protected const CHILD_NAMES = ['variable', 'is', 'isType', 'question', 'left', 'colon', 'right'];
    public function __construct(public \Phpactor\DocblockParser\Ast\VariableNode $variable, public ?\Phpactor\DocblockParser\Ast\Token $is = null, public ?\Phpactor\DocblockParser\Ast\TypeNode $isType = null, public ?\Phpactor\DocblockParser\Ast\Token $question = null, public ?\Phpactor\DocblockParser\Ast\TypeNode $left = null, public ?\Phpactor\DocblockParser\Ast\Token $colon = null, public ?\Phpactor\DocblockParser\Ast\TypeNode $right = null)
    {
    }
}
