<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\ValueNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\VariableNode;
class ParameterTag extends TagNode
{
    protected const CHILD_NAMES = ['type', 'name', 'default'];
    public function __construct(public ?TypeNode $type, public ?VariableNode $name, public ?ValueNode $default)
    {
    }
    public function parameterName() : ?string
    {
        if (null === $this->name) {
            return null;
        }
        return $this->name->name()->toString();
    }
    public function type() : ?TypeNode
    {
        return $this->type;
    }
    public function default() : ?ValueNode
    {
        return $this->default;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\ParameterTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\ParameterTag', \false);
