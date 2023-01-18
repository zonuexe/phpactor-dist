<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ExtendsTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'type'];
    public function __construct(public Token $tag, public ?TypeNode $type = null)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\ExtendsTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\ExtendsTag', \false);
