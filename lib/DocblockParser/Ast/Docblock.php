<?php

namespace Phpactor\DocblockParser\Ast;

use Generator;
class Docblock extends \Phpactor\DocblockParser\Ast\Node
{
    protected const CHILD_NAMES = ['children'];
    /**
     * @var ElementList<Element>
     */
    public \Phpactor\DocblockParser\Ast\ElementList $children;
    /**
     * @param Element[] $children
     */
    public function __construct(array $children)
    {
        $this->children = new \Phpactor\DocblockParser\Ast\ElementList($children);
    }
    /**
     * @param class-string $tagFqn
     */
    public function hasTag(string $tagFqn) : bool
    {
        foreach ($this->tags() as $tag) {
            if ($tag instanceof $tagFqn) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return class-string[]
     */
    public function tagTypes() : array
    {
        $types = [];
        foreach ($this->tags() as $tag) {
            if ($tag instanceof \Phpactor\DocblockParser\Ast\UnknownTag) {
                continue;
            }
            $types[$tag::class] = \true;
        }
        return \array_keys($types);
    }
    /**
     * @template T of TagNode
     * @param class-string<T>|null $tagFqn
     * @return ($tagFqn is string ? Generator<T> : Generator<TagNode>)
     */
    public function tags(?string $tagFqn = null) : Generator
    {
        foreach ($this->children as $child) {
            if ($tagFqn && $child instanceof $tagFqn) {
                (yield $child);
                continue;
            }
            if (!$tagFqn && $child instanceof \Phpactor\DocblockParser\Ast\TagNode) {
                (yield $child);
                continue;
            }
        }
    }
    public function phpDocOpen() : ?\Phpactor\DocblockParser\Ast\Token
    {
        foreach ($this->tokens() as $token) {
            if ($token->type === \Phpactor\DocblockParser\Ast\Token::T_PHPDOC_OPEN) {
                return $token;
            }
        }
        return null;
    }
    public function prose() : string
    {
        $prose = [];
        foreach ($this->descendantElements() as $child) {
            if ($child instanceof \Phpactor\DocblockParser\Ast\TagNode) {
                break;
            }
            if (!$child instanceof \Phpactor\DocblockParser\Ast\Token) {
                continue;
            }
            if (\in_array($child->type, [\Phpactor\DocblockParser\Ast\Token::T_PHPDOC_OPEN, \Phpactor\DocblockParser\Ast\Token::T_PHPDOC_CLOSE, \Phpactor\DocblockParser\Ast\Token::T_ASTERISK])) {
                continue;
            }
            if ($child->type === \Phpactor\DocblockParser\Ast\Token::T_TAG) {
                break;
            }
            $prose[] = $child->value;
        }
        return \implode("\n", \array_map('trim', \explode("\n", \implode('', $prose))));
    }
    public function lastMultilineContentToken() : ?\Phpactor\DocblockParser\Ast\Token
    {
        $hasLeading = \false;
        $lastToken = null;
        foreach ($this->tokens() as $child) {
            if ($child->type === \Phpactor\DocblockParser\Ast\Token::T_ASTERISK) {
                $hasLeading = \true;
            }
            if ($child->type === \Phpactor\DocblockParser\Ast\Token::T_PHPDOC_CLOSE && $hasLeading) {
                return $lastToken;
            }
            $lastToken = $child;
        }
        return null;
    }
    public function indentationLevel() : int
    {
        $previous = null;
        foreach ($this->children->elements as $child) {
            if (!$child instanceof \Phpactor\DocblockParser\Ast\Token) {
                continue;
            }
            if ($child->type === \Phpactor\DocblockParser\Ast\Token::T_ASTERISK) {
                return $previous->length();
            }
            if ($child->type === \Phpactor\DocblockParser\Ast\Token::T_PHPDOC_CLOSE) {
                return $previous->length();
            }
            $previous = $child;
        }
        return 0;
    }
}
