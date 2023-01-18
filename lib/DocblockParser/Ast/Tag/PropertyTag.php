<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class PropertyTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'type', 'name'];
    public function __construct(public Token $tag, public ?TypeNode $type, public ?Token $name)
    {
    }
    public function propertyName() : ?string
    {
        if (null === $this->name) {
            return null;
        }
        return $this->name->toString();
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\PropertyTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\PropertyTag', \false);
