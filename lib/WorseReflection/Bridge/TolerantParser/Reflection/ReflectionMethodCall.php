<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
class ReflectionMethodCall extends AbstractReflectionMethodCall
{
    private MemberAccessExpression $node;
    public function __construct(ServiceLocator $locator, Frame $frame, MemberAccessExpression $node)
    {
        parent::__construct($locator, $frame, $node);
    }
    public function isStatic() : bool
    {
        return \false;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionMethodCall', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionMethodCall', \false);
