<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use PhpactorDist\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor\WorseReflection\Core\ServiceLocator;
class ReflectionMethodCall extends \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\AbstractReflectionMethodCall
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
