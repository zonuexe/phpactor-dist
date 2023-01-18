<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast;

class ConditionalNode extends TypeNode
{
    protected const CHILD_NAMES = ['variable', 'is', 'isType', 'question', 'left', 'colon', 'right'];
    public function __construct(public VariableNode $variable, public ?Token $is = null, public ?TypeNode $isType = null, public ?Token $question = null, public ?TypeNode $left = null, public ?Token $colon = null, public ?TypeNode $right = null)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\ConditionalNode', 'Phpactor\\DocblockParser\\Ast\\ConditionalNode', \false);
