<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Type\ClassNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class MixinTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'class'];
    public function __construct(public Token $tag, public ?ClassNode $class)
    {
    }
    public function class() : ?ClassNode
    {
        return $this->class;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\MixinTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\MixinTag', \false);
