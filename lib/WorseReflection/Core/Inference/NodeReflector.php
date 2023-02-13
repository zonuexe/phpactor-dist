<?php

namespace Phpactor\WorseReflection\Core\Inference;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Attribute;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\CallExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionAttribute;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionMethodCall;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionObjectCreationExpression as PhpactorReflectionObjectCreationExpression;
use Phpactor\WorseReflection\Core\Exception\CouldNotResolveNode;
use Phpactor\WorseReflection\Core\Reflection\ReflectionNode;
use Phpactor\WorseReflection\Core\Reflection\ReflectionObjectCreationExpression;
use Phpactor\WorseReflection\Core\ServiceLocator;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionStaticMethodCall;
class NodeReflector
{
    public function __construct(private ServiceLocator $services)
    {
    }
    public function reflectNode(\Phpactor\WorseReflection\Core\Inference\Frame $frame, Node $node) : ReflectionNode
    {
        if ($node instanceof MemberAccessExpression) {
            return $this->reflectMemberAccessExpression($frame, $node);
        }
        if ($node instanceof ScopedPropertyAccessExpression) {
            return $this->reflectScopedPropertyAccessExpression($frame, $node);
        }
        if ($node instanceof ObjectCreationExpression) {
            return $this->reflectObjectCreationExpression($frame, $node);
        }
        if ($node->parent instanceof Attribute) {
            return $this->reflectAttribute($frame, $node->parent);
        }
        throw new CouldNotResolveNode(\sprintf('Did not know how to reflect node of type "%s"', \get_class($node)));
    }
    private function reflectScopedPropertyAccessExpression(\Phpactor\WorseReflection\Core\Inference\Frame $frame, ScopedPropertyAccessExpression $node) : ReflectionStaticMethodCall
    {
        if ($node->parent instanceof CallExpression) {
            return $this->reflectStaticMethodCall($frame, $node);
        }
        throw new CouldNotResolveNode(\sprintf('Did not know how to reflect node of type "%s"', \get_class($node)));
    }
    private function reflectMemberAccessExpression(\Phpactor\WorseReflection\Core\Inference\Frame $frame, MemberAccessExpression $node) : ReflectionMethodCall
    {
        if ($node->parent instanceof CallExpression) {
            return $this->reflectMethodCall($frame, $node);
        }
        throw new CouldNotResolveNode(\sprintf('Did not know how to reflect node of type "%s"', \get_class($node)));
    }
    private function reflectMethodCall(\Phpactor\WorseReflection\Core\Inference\Frame $frame, MemberAccessExpression $node) : ReflectionMethodCall
    {
        return new ReflectionMethodCall($this->services, $frame, $node);
    }
    private function reflectStaticMethodCall(\Phpactor\WorseReflection\Core\Inference\Frame $frame, ScopedPropertyAccessExpression $node) : ReflectionStaticMethodCall
    {
        return new ReflectionStaticMethodCall($this->services, $frame, $node);
    }
    private function reflectObjectCreationExpression(\Phpactor\WorseReflection\Core\Inference\Frame $frame, ObjectCreationExpression $node) : ReflectionObjectCreationExpression
    {
        return new PhpactorReflectionObjectCreationExpression($this->services, $frame, $node);
    }
    private function reflectAttribute(\Phpactor\WorseReflection\Core\Inference\Frame $frame, Attribute $node) : ReflectionNode
    {
        return new ReflectionAttribute($this->services, $frame, $node);
    }
}
