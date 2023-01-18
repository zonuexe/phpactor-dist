<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\EnumDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionEnum;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass as PhpactorReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionInterface;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionClass;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionTrait;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Microsoft\PhpParser\ClassLike;
use Phpactor202301\Microsoft\PhpParser\Node;
/**
 * @extends AbstractReflectionCollection<ReflectionClassLike>
 */
final class ReflectionClassLikeCollection extends AbstractReflectionCollection
{
    /**
     * @param array<string,bool> $visited
     */
    public static function fromNode(ServiceLocator $serviceLocator, SourceCode $source, Node $node, array $visited = []) : self
    {
        $items = [];
        $nodeCollection = $node->getDescendantNodes(function (Node $node) {
            return \false === $node instanceof ClassLike;
        });
        foreach ($nodeCollection as $child) {
            if (\false === $child instanceof ClassLike) {
                continue;
            }
            if ($child instanceof TraitDeclaration) {
                $items[(string) $child->getNamespacedName()] = new ReflectionTrait($serviceLocator, $source, $child, $visited);
                continue;
            }
            if ($child instanceof EnumDeclaration) {
                $items[(string) $child->getNamespacedName()] = new ReflectionEnum($serviceLocator, $source, $child);
                continue;
            }
            if ($child instanceof InterfaceDeclaration) {
                $items[(string) $child->getNamespacedName()] = new ReflectionInterface($serviceLocator, $source, $child, $visited);
                continue;
            }
            if ($child instanceof ClassDeclaration) {
                $items[(string) $child->getNamespacedName()] = new ReflectionClass($serviceLocator, $source, $child, $visited);
            }
        }
        return new static($items);
    }
    public function classes() : ReflectionClassCollection
    {
        /** @phpstan-ignore-next-line */
        return new ReflectionClassCollection(\iterator_to_array($this->byMemberClass(PhpactorReflectionClass::class)));
    }
    public function concrete() : self
    {
        return new static(\array_filter($this->items, function ($item) {
            return $item->isConcrete();
        }));
    }
}
/**
 * @extends AbstractReflectionCollection<ReflectionClassLike>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionClassLikeCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionClassLikeCollection', \false);
