<?php

namespace Phpactor\DocblockParser\Ast;

class VariableNode extends \Phpactor\DocblockParser\Ast\Node
{
    protected const CHILD_NAMES = ['name'];
    public function __construct(public \Phpactor\DocblockParser\Ast\Token $name)
    {
    }
    public function name() : \Phpactor\DocblockParser\Ast\Token
    {
        return $this->name;
    }
}
