<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast;

class UnknownTag extends TagNode
{
    protected const CHILD_NAMES = ['name'];
    public function __construct(public Token $name)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\UnknownTag', 'Phpactor\\DocblockParser\\Ast\\UnknownTag', \false);
