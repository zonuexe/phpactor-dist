<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Tag;

use Phpactor202301\Phpactor\DocblockParser\Ast\TagNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\TextNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class DeprecatedTag extends TagNode
{
    public const CHILD_NAMES = ['token', 'text'];
    public function __construct(public Token $token, public ?TextNode $text)
    {
    }
    public function text() : ?string
    {
        if ($this->text) {
            return $this->text->toString();
        }
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Tag\\DeprecatedTag', 'Phpactor\\DocblockParser\\Ast\\Tag\\DeprecatedTag', \false);
