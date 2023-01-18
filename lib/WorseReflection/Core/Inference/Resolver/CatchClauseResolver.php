<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\CatchClause;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Symbol;
class CatchClauseResolver implements Resolver
{
    public function resolve(NodeContextResolver $resolver, Frame $frame, Node $node) : NodeContext
    {
        $context = NodeContextFactory::create('catch', $node->getStartPosition(), $node->getEndPosition());
        \assert($node instanceof CatchClause);
        /** @phpstan-ignore-next-line Lies */
        if (!$node->qualifiedNameList instanceof QualifiedNameList) {
            return $context;
        }
        /** @phpstan-ignore-next-line Lies */
        $type = $resolver->resolveNode($frame, $node->qualifiedNameList)->type();
        $variableName = $node->variableName;
        if (null === $variableName) {
            return $context;
        }
        $context = NodeContextFactory::create((string) $variableName->getText($node->getFileContents()), $variableName->getStartPosition(), $variableName->getEndPosition(), ['symbol_type' => Symbol::VARIABLE, 'type' => $type]);
        $frame->locals()->set(Variable::fromSymbolContext($context));
        return $context;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\CatchClauseResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\CatchClauseResolver', \false);
