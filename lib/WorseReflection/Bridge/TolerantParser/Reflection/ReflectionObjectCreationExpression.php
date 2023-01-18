<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\CouldNotResolveNode;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionArgumentCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionObjectCreationExpression as PhpactorReflectionObjectCreationExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ReflectedClassType;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionScope as TolerantReflectionScope;
class ReflectionObjectCreationExpression implements PhpactorReflectionObjectCreationExpression
{
    public function __construct(private ServiceLocator $locator, private Frame $frame, private ObjectCreationExpression $node)
    {
    }
    public function scope() : ReflectionScope
    {
        return new TolerantReflectionScope($this->locator->reflector(), $this->node);
    }
    public function position() : Position
    {
        return Position::fromFullStartStartAndEnd($this->node->getFullStartPosition(), $this->node->getStartPosition(), $this->node->getEndPosition());
    }
    public function class() : ReflectionClassLike
    {
        $type = $this->locator->symbolContextResolver()->resolveNode($this->frame, $this->node->classTypeDesignator)->type();
        if (!$type instanceof ReflectedClassType) {
            throw new CouldNotResolveNode(\sprintf('Expceted "%s" but got "%s"', ReflectedClassType::class, \get_class($type)));
        }
        $reflection = $type->reflectionOrNull();
        if (null === $reflection) {
            throw new CouldNotResolveNode('Could not reflect class');
        }
        return $reflection;
    }
    public function arguments() : ReflectionArgumentCollection
    {
        if (null === $this->node->argumentExpressionList) {
            return ReflectionArgumentCollection::empty();
        }
        return ReflectionArgumentCollection::fromArgumentListAndFrame($this->locator, $this->node->argumentExpressionList, $this->frame);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionObjectCreationExpression', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionObjectCreationExpression', \false);
