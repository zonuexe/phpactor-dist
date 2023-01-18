<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class ListBracketsNode extends TypeNode
{
    protected const CHILD_NAMES = ['type', 'listChars'];
    public function __construct(public TypeNode $type, public Token $listChars)
    {
    }
    public function type() : TypeNode
    {
        return $this->type;
    }
    public function listChars() : Token
    {
        return $this->listChars;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\ListBracketsNode', 'Phpactor\\DocblockParser\\Ast\\Type\\ListBracketsNode', \false);
