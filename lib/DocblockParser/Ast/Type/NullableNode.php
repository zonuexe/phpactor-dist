<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class NullableNode extends TypeNode
{
    protected const CHILD_NAMES = ['nullable', 'type'];
    public function __construct(public Token $nullable, public TypeNode $type)
    {
    }
    public function nullable() : Token
    {
        return $this->nullable;
    }
    public function type() : TypeNode
    {
        return $this->type;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\NullableNode', 'Phpactor\\DocblockParser\\Ast\\Type\\NullableNode', \false);
