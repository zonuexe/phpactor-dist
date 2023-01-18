<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\UnionType;
class QualifiedNameListResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        \assert($node instanceof QualifiedNameList);
        $types = [];
        $firstType = null;
        foreach ($node->getChildNodes() as $child) {
            if (!$child instanceof QualifiedName) {
                continue;
            }
            if (null === $firstType) {
                $firstType = $child;
            }
            $types[] = $resolver->resolveNode($frame, $child)->type();
        }
        $type = new UnionType(...$types);
        return NodeContextFactory::create($node->getText(), $node->getStartPosition(), $node->getEndPosition(), ['type' => $type->reduce(), 'symbol_type' => Symbol::CLASS_]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\QualifiedNameListResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\QualifiedNameListResolver', \false);