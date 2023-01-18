<?php

namespace Phpactor202301\Phpactor\Extension\Symfony\Completor;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\StringLiteral;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Extension\Symfony\Model\SymfonyContainerInspector;
use Phpactor202301\Phpactor\Extension\Symfony\Model\SymfonyContainerService;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class SymfonyContainerCompletor implements TolerantCompletor
{
    const CONTAINER_CLASS = 'Phpactor202301\\Symfony\\Component\\DependencyInjection\\ContainerInterface';
    public function __construct(private Reflector $reflector, private SymfonyContainerInspector $inspector)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        $inQuote = \false;
        if ($node instanceof StringLiteral && $node->parent->parent) {
            $inQuote = \true;
            $node = $node->getFirstAncestor(CallExpression::class);
        }
        if ($node instanceof QualifiedName) {
            $node = $node->getFirstAncestor(CallExpression::class);
        }
        if (!$node instanceof CallExpression) {
            return;
        }
        $memberAccess = $node->callableExpression;
        if (!$memberAccess instanceof MemberAccessExpression) {
            return;
        }
        $methodName = NodeUtil::nameFromTokenOrNode($node, $memberAccess->memberName);
        if ($methodName !== 'get') {
            return;
        }
        $expression = $memberAccess->dereferencableExpression;
        $containerType = $this->reflector->reflectOffset($source, $expression->getEndPosition())->symbolContext()->type();
        if ($containerType->instanceof(TypeFactory::class(self::CONTAINER_CLASS))->isFalseOrMaybe()) {
            return;
        }
        foreach ($this->inspector->services() as $service) {
            $label = $service->id;
            $suggestion = $inQuote ? $service->id : \sprintf('\'%s\'', $service->id);
            $import = null;
            if ($this->serviceIdIsFqn($service) && $inQuote) {
                continue;
            }
            if (\false === $this->serviceIdIsFqn($service) && \false === $inQuote) {
                continue;
            }
            if (\false === $inQuote && $this->serviceIdIsFqn($service)) {
                $suggestion = $service->type->short() . '::class';
                $label = $service->type->short() . '::class';
                $import = $service->type->__toString();
            }
            (yield Suggestion::createWithOptions($suggestion, ['label' => $label, 'short_description' => $service->id, 'documentation' => \sprintf('**Symfony Service**: %s', $service->type->__toString()), 'type' => Suggestion::TYPE_VALUE, 'name_import' => $import, 'priority' => 555]));
        }
        return \true;
    }
    private function serviceIdIsFqn(SymfonyContainerService $service) : bool
    {
        return $service->type->isClass() && $service->id === $service->type->__toString();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Symfony\\Completor\\SymfonyContainerCompletor', 'Phpactor\\Extension\\Symfony\\Completor\\SymfonyContainerCompletor', \false);