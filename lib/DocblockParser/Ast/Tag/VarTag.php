<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\VariableNode;
class VarTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'type', 'variable'];
    public function __construct(public Token $tag, public ?TypeNode $type, public ?VariableNode $variable)
    {
    }
    public function type() : ?TypeNode
    {
        return $this->type;
    }
    public function variable() : ?VariableNode
    {
        return $this->variable;
    }
    public function name() : ?string
    {
        if (null === $this->variable) {
            return null;
        }
        return $this->variable->name()->toString();
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\VarTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\VarTag', \false);
