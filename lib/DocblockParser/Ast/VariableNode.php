<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast;

class VariableNode extends Node
{
    protected const CHILD_NAMES = ['name'];
    public function __construct(public Token $name)
    {
    }
    public function name() : Token
    {
        return $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\VariableNode', 'Phpactor\\DocblockParser\\Ast\\VariableNode', \false);
