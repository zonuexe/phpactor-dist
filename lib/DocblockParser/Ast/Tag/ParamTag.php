<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\TextNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\VariableNode;
class ParamTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'type', 'variable', 'text'];
    public function __construct(public Token $tag, public ?TypeNode $type, public ?VariableNode $variable, public ?TextNode $text = null)
    {
    }
    public function paramName() : ?string
    {
        if (null === $this->variable) {
            return null;
        }
        return $this->variable->name()->toString();
    }
    public function type() : ?TypeNode
    {
        return $this->type;
    }
    public function variable() : ?VariableNode
    {
        return $this->variable;
    }
    public function text() : ?TextNode
    {
        return $this->text;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\ParamTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\ParamTag', \false);
