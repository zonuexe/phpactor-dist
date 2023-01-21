<?php

namespace Phpactor\DocblockParser\Ast;

class UnknownTag extends \Phpactor\DocblockParser\Ast\TagNode
{
    protected const CHILD_NAMES = ['name'];
    public function __construct(public \Phpactor\DocblockParser\Ast\Token $name)
    {
    }
}
