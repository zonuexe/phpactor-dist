<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class ScalarNode extends TypeNode
{
    protected const CHILD_NAMES = ['name'];
    public function __construct(public Token $name)
    {
    }
    public function name() : Token
    {
        return $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\ScalarNode', 'Phpactor\\DocblockParser\\Ast\\Type\\ScalarNode', \false);
