<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ArrayNode extends TypeNode
{
    protected const CHILD_NAMES = ['type'];
    public function __construct(public Token $type)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\ArrayNode', 'Phpactor\\DocblockParser\\Ast\\Type\\ArrayNode', \false);
