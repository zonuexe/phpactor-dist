<?php

namespace Phpactor\DocblockParser\Ast;

class TextNode extends \Phpactor\DocblockParser\Ast\Node
{
    protected const CHILD_NAMES = ['tokens'];
    /**
     * @param Token[] $tokens
     */
    public function __construct(public array $tokens)
    {
    }
    public function toString() : string
    {
        return \trim(\implode('', \array_filter(\array_map(function (\Phpactor\DocblockParser\Ast\Token $token) {
            if (\in_array($token->type, [\Phpactor\DocblockParser\Ast\Token::T_PHPDOC_OPEN, \Phpactor\DocblockParser\Ast\Token::T_PHPDOC_CLOSE, \Phpactor\DocblockParser\Ast\Token::T_ASTERISK])) {
                return \false;
            }
            if (\str_contains($token->value, "\n")) {
                return ' ';
            }
            return $token->value;
        }, $this->tokens))));
    }
}
