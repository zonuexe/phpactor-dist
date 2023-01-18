<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class TemplateTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'placeholder', 'constraint', 'type'];
    public function __construct(public Token $tag, public ?Token $placeholder = null, public ?Token $constraint = null, public ?TypeNode $type = null)
    {
    }
    public function placeholder() : string
    {
        return $this->placeholder ? $this->placeholder->toString() : '';
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\TemplateTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\TemplateTag', \false);
