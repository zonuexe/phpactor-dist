<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\TextNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ReturnTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'type', 'text'];
    public function __construct(public Token $tag, public ?TypeNode $type, public ?TextNode $text = null)
    {
    }
    public function type() : ?TypeNode
    {
        return $this->type;
    }
    public function text() : ?TextNode
    {
        return $this->text;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\ReturnTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\ReturnTag', \false);
