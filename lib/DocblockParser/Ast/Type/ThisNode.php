<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ThisNode extends TypeNode
{
    protected const CHILD_NAMES = ['name'];
    public function __construct(public Token $name)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\ThisNode', 'Phpactor\\DocblockParser\\Ast\\Type\\ThisNode', \false);
