<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\NavigatorElementCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
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
                $calls[] = new ReflectionMethodCall($this->locator, new Frame('test'), $node);
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
            $elements[] = new ReflectionPropertyAccess($node);
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
            $elements[] = new ReflectionConstantAccess($node);
        }
        return new NavigatorElementCollection($elements);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionNavigation', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionNavigation', \false);
