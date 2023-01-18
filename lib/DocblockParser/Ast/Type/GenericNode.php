<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\Element;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeList;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class GenericNode extends TypeNode
{
    protected const CHILD_NAMES = ['type', 'open', 'parameters', 'close'];
    /**
     * @param TypeList<Element> $parameters
     */
    public function __construct(public Token $open, public TypeNode $type, public TypeList $parameters, public Token $close)
    {
    }
    public function close() : Token
    {
        return $this->close;
    }
    public function open() : Token
    {
        return $this->open;
    }
    /**
     * @return TypeList<Element>
     */
    public function parameters() : TypeList
    {
        return $this->parameters;
    }
    public function type() : TypeNode
    {
        return $this->type;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\GenericNode', 'Phpactor\\DocblockParser\\Ast\\Type\\GenericNode', \false);
