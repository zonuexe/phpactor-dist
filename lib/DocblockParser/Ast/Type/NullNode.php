<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class NullNode extends TypeNode
{
    protected const CHILD_NAMES = ['null'];
    public function __construct(public Token $null)
    {
    }
    public function null() : Token
    {
        return $this->null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\NullNode', 'Phpactor\\DocblockParser\\Ast\\Type\\NullNode', \false);
