<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ThrowsTag extends TagNode
{
    protected const CHILD_NAMES = ['tag', 'exceptionClass'];
    public function __construct(public Token $tag, public ?TypeNode $exceptionClass)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\ThrowsTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\ThrowsTag', \false);
