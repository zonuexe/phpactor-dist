<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class LiteralStringNode extends TypeNode
{
    protected const CHILD_NAMES = ['token'];
    public function __construct(public Token $token)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\LiteralStringNode', 'Phpactor\\DocblockParser\\Ast\\Type\\LiteralStringNode', \false);