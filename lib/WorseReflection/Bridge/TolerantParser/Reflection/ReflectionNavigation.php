<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\CallExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\NavigatorElementCollection;
use Phpactor\WorseReflection\Core\ServiceLocator;
class ReflectionNavigation
{
    public function __construct(private ServiceLocator $locator, private Node $node)
    {
    }
    /**
     * @return NavigatorElementCollection<ReflectionMethodCall>
     */
    public function methodCalls() : NavigatorElementCollection
    {
        $calls = [];
        foreach ($this->node->getDescendantNodes() as $node) {
            if ($node instanceof MemberAccessExpression) {
                if (!$node->parent instanceof CallExpression) {
                    continue;
                }
                $calls[] = new \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionMethodCall($this->locator, new Frame('test'), $node);
            }
        }
        return new NavigatorElementCollection($calls);
    }
    public function at(ByteOffset $offset) : self
    {
        return new self($this->locator, $this->node->getDescendantNodeAtPosition($offset->toInt()));
    }
    /**
     * @return NavigatorElementCollection<ReflectionPropertyAccess>
     */
    public function propertyAccesses() : NavigatorElementCollection
    {
        $elements = [];
        foreach ($this->node->getDescendantNodes() as $node) {
            if (!$node instanceof MemberAccessExpression) {
                continue;
            }
            if ($node->parent instanceof CallExpression) {
                continue;
            }
            $elements[] = new \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionPropertyAccess($node);
        }
        return new NavigatorElementCollection($elements);
    }
    /**
     * @return NavigatorElementCollection<ReflectionConstantAccess>
     */
    public function constantAccesses() : NavigatorElementCollection
    {
        $elements = [];
        foreach ($this->node->getDescendantNodes() as $node) {
            if (!$node instanceof ScopedPropertyAccessExpression) {
                continue;
            }
            if ($node->parent instanceof CallExpression) {
                continue;
            }
            $elements[] = new \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionConstantAccess($node);
        }
        return new NavigatorElementCollection($elements);
    }
}
