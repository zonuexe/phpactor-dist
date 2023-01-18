<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
class ReflectionStaticMethodCall extends AbstractReflectionMethodCall
{
    public function __construct(ServiceLocator $locator, Frame $frame, ScopedPropertyAccessExpression $node)
    {
        parent::__construct($locator, $frame, $node);
    }
    public function isStatic() : bool
    {
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionStaticMethodCall', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionStaticMethodCall', \false);
