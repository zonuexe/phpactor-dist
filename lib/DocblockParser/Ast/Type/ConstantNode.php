<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ConstantNode extends TypeNode
{
    protected const CHILD_NAMES = ['name', 'doubleColon', 'constant'];
    public function __construct(public TypeNode $name, public Token $doubleColon, public Token $constant)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\ConstantNode', 'Phpactor\\DocblockParser\\Ast\\Type\\ConstantNode', \false);
