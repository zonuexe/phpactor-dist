<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\TypeList;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class UnionNode extends TypeNode
{
    protected const CHILD_NAMES = ['types'];
    public function __construct(public TypeList $types)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\UnionNode', 'Phpactor\\DocblockParser\\Ast\\Type\\UnionNode', \false);
