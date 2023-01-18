<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\StringLiteral;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class StringLiteralResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof StringLiteral);
        // TODO: [TP] tolerant parser method returns the quotes
        $value = (string) $this->getStringContentsText($node);
        return NodeContextFactory::create('string', $node->getStartPosition(), $node->getEndPosition(), ['symbol_type' => Symbol::STRING, 'type' => TypeFactory::stringLiteral($value), 'container_type' => NodeUtil::nodeContainerClassLikeType($resolver->reflector(), $node)]);
    }
    private function getStringContentsText(StringLiteral $node) : string
    {
        $children = $node->children;
        if (\is_array($children) && \array_key_exists(0, $children)) {
            $children = $children[0];
        }
        if ($children instanceof Token) {
            $value = (string) $children->getText($node->getFileContents());
            $startQuote = \substr($node, 0, 1);
            return match ($startQuote) {
                '\'' => \rtrim(\substr($value, 1), '\''),
                '"' => \rtrim(\substr($value, 1), '"'),
                '<' => \trim($value),
                default => '',
            };
        }
        return '';
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\StringLiteralResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\StringLiteralResolver', \false);